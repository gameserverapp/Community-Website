<?php
namespace GameserverApp\Api;

use App\Exceptions\DomainNotFoundException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Cache\CacheManager;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\UnauthorizedException;
use GameserverApp\Helpers\PremiumHostedHelper;
use GameserverApp\Transformers\UserTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OAuthApi
{
    const TOKEN_COOKIE_NAME = 'premium_api_token';

    public static function getAccessTokensWithAuthorizationCode($code)
    {
        return self::client()->post('oauth/token', [
            'form_params' => [
                'grant_type'    => 'authorization_code',
                'client_id'     => PremiumHostedHelper::clientId(),
                'client_secret' => PremiumHostedHelper::clientSecret(),
                'code'          => $code,
                'redirect'      => PremiumHostedHelper::redirectUrl()
            ],
        ]);
    }

    public static function isAuth()
    {
        return self::hasAuthCookies() and self::user();
    }

    public static function user()
    {
        if( !$headers['Authorization'] = self::authHeader()) {
            return false;
        }

        try {
            $response = self::authRequest('get', 'user/me', [], config('gameserverapp.cache.get_user_ttl'));

            if($response instanceof \Exception) {
                throw new UnauthorizedException();
            }

            return UserTransformer::transform($response);
        } catch (ClientException $e) {
            return false;
        }
    }

    public static function hasAuthCookies()
    {
        return Cookie::has(OAuthApi::TOKEN_COOKIE_NAME);
    }

    public static function authHeader()
    {
        if(!Cookie::has(OAuthApi::TOKEN_COOKIE_NAME)) {
            return false;
        }

        return 'Bearer ' . Cookie::get(OAuthApi::TOKEN_COOKIE_NAME);
    }

    public static function setTokenCookie($tokens)
    {
        Cookie::queue(
            self::TOKEN_COOKIE_NAME,
            $tokens->access_token,
            $tokens->expires_in / 60
        );
    }

    public static function authRequest($method, $uri, $options = [], $cacheTtl = true)
    {
        $cacheKey = self::cacheKey([[$method, $uri, $options], self::getHeaders(true)]);

        if($cacheTtl === true) {
            $cacheTtl = config('gameserverapp.cache.default_cache_ttl');
        }
        
        return self::request(
            self::client(true),
            $method,
            $uri,
            $options,
            $cacheKey,
            $cacheTtl
        );
    }

    public static function guestRequest($method, $uri, $options = [], $cacheTtl = true)
    {
        $cacheKey = self::cacheKey([[$method, $uri, $options], self::getHeaders(false)]);

        if($cacheTtl === true) {
            $cacheTtl = config('gameserverapp.cache.default_cache_ttl');
        }

        return self::request(
            self::client(false),
            $method,
            $uri,
            $options,
            $cacheKey,
            $cacheTtl
        );
    }

    private static function request(
        \GuzzleHttp\Client $client,
        $method,
        $uri,
        $options = [],
        $cacheKey,
        $cache
    ) {        
        if(
            config('gameserverapp.oauthapi_allow_cache', true) and
            $method == 'get' and
            $cache and
            self::cache()->has($cacheKey)
        ) {
            return self::cache()->get($cacheKey);
        }

        try {
            $output = $client->request($method, $uri, $options);

            if( $output->getStatusCode() != 200 ) {
                return $output;
            }

            $output = json_decode($output->getBody());

            if($cache) {
                self::cache()->put( $cacheKey, $output, $cache );
            }

            return $output;

        } catch (ClientException $e) {

            if($e->getCode() == 404) {
                $response = json_decode($e->getResponse()->getBody());

                if(isset($response->redirect_url)) {
                    throw new DomainNotFoundException($e);
                }
            }

            if(!isset($options['no_404_exception']) and $e->getCode() == 404) {
                throw new NotFoundHttpException($e);
            }

            return $e;
        } catch (ServerException $e) {
            if($e->getCode() == 503) {
                throw new MaintenanceModeException(time(), 0, $e->getMessage(), $e->getPrevious(), $e->getCode());
            }

            return $e;
        } catch (ConnectException $e) {
            return $e;
        }
    }

    public static function clearCache($method, $uri, $options = [], $auth = false)
    {
        $cacheKey = self::cacheKey([[$method, $uri, $options], self::getHeaders($auth)]);

        return self::cache()->forget($cacheKey);
    }

    public static function clearAllCache()
    {
        return self::cache()->flush();
    }

    public static function logout()
    {
        Cookie::queue(
            Cookie::forget(OAuthApi::TOKEN_COOKIE_NAME)
        );
    }
    
    public static function getHeaders($auth = false)
    {
        $headers = [
            'User-Agent'     => 'GameserverApp-Frontend/1.0',
            'Accept'         => 'application/json',
        ];

        if ($auth and self::hasAuthCookies()) {
            $headers['Authorization'] = self::authHeader();
        }

        if(env('PREMIUM_GUI_API_KEY', false)) {
            $headers[env('PREMIUM_GUI_API_HEADER')] = env('PREMIUM_GUI_API_KEY', false);
            $headers['premium-domain'] = self::domain();
        } else {
            $headers['X-AUTH-GSA-CLIENT-ID'] = config('gameserverapp.connection.client_id');
        }

        return $headers;
    }

    private static function tags()
    {
        return self::domain();
    }

    private static function client($auth = false)
    {
        $headers = self::getHeaders($auth);

        return new  \GuzzleHttp\Client([
            'base_uri' => config('gameserverapp.connection.url'),
            'headers'  => $headers,
            'timeout' => config('gameserverapp.connection.timeout'),
            'verify' => app()->environment('dev')
            //'http_errors' => false
        ]);
    }

    private static function cacheKey($args)
    {
        return md5(serialize($args));
    }

    private static function cache()
    {
        return app(CacheManager::class)->tags(self::tags());
    }

    private static function domain()
    {
        return domain();
    }
}