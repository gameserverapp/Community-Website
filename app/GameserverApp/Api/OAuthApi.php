<?php
namespace GameserverApp\Api;

use App\Exceptions\DomainNotFoundException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\UnauthorizedException;
use GameserverApp\Helpers\PremiumHostedHelper;
use GameserverApp\Transformers\UserTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class OAuthApi
{
    const TOKEN_COOKIE_NAME = 'premium_api_token';

    public static function requestOriginInfo()
    {
        return [
            'query' => [
                'url' => base64_encode(request()->getHost()),
                'ip' => base64_encode(request()->ip()),
            ]
        ];
    }

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

    public static function user()
    {
        try {
            $response = self::authRequest(
                'get',
                'user/me',
                OauthApi::requestOriginInfo(),
                config('gameserverapp.cache.get_user_ttl')
            );

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

    public static function authRequest(
        $method,
        $uri,
        $options = [],
        $cacheTtl = true
    ) {
        $cacheKey = self::cacheKey([
            [$method, $uri, $options],
            self::getHeaders(true)
        ]);

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

    public static function guestRequest(
        $method,
        $uri,
        $options = [],
        $cacheTtl = true
    ) {
        $cacheKey = self::cacheKey([
            [$method, $uri, $options],
            self::getHeaders()
        ]);

        if($cacheTtl === true) {
            $cacheTtl = config('gameserverapp.cache.default_cache_ttl');
        }

        return self::request(
            self::client(),
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
        if($cache and is_numeric($cache)) {
            $cache = $cache * 60;
        }

        $oldCacheKey = $cacheKey . '_old';

        try {

            return Cache::lock($cacheKey)->get(function () use ($client, $method, $uri, $options, $cacheKey, $cache, $oldCacheKey) {

                if (
                    config('gameserverapp.oauthapi_allow_cache', true) and
                    $method == 'get' and
                    $cache and
                    self::cache()->has($cacheKey)
                ) {
                    return self::cache()->get($cacheKey);
                }

                try {
                    $output = $client->request($method, $uri, $options);

                    if ($output->getStatusCode() != 200) {
                        return $output;
                    }

                    $output = json_decode($output->getBody());

                    if ($cache) {
                        self::cache()->put($cacheKey, $output, $cache);
                        self::cache()->put($oldCacheKey, $output, 3600);
                    }

                    return $output;
                } catch (ClientException $e) {

                    if ($e->getCode() == 404) {
                        $response = json_decode($e->getResponse()->getBody());

                        if (isset($response->redirect_url)) {
                            throw new DomainNotFoundException($e);
                        }
                    }

                    if ($e->getCode() == 429) {
                        abort(429);
                    }

                    if (! isset($options['no_404_exception']) and $e->getCode() == 404) {
                        throw new NotFoundHttpException($e);
                    }

                    throw $e;
                } catch (ServerException $e) {
                    if ($e->getCode() == 503) {
                        throw new MaintenanceModeException(time(), 0, $e->getMessage(), $e->getPrevious(),
                            $e->getCode());
                    }

                    throw $e;
                } catch (ConnectException $e) {
                    throw $e;
                }
            });
        } catch (Throwable $e) {

            if (
                config('gameserverapp.oauthapi_allow_cache', true) and
                $method == 'get' and
                $cache and
                self::cache()->has($cacheKey)
            ) {
                return self::cache()->get($cacheKey);
            }

            return $e; //todo this should be done better
        }
    }

    public static function clearCache(
        $method,
        $uri,
        $options = [],
        $auth = false
    ) {
        $cacheKey = self::cacheKey([
            [$method, $uri, $options],
            self::getHeaders($auth)
        ]);

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
    
    public static function getHeaders($auth = null)
    {
        $headers = [
            'User-Agent'     => 'GameServerApp-Frontend/1.1',
            'Accept'         => 'application/json',
        ];

        if (
            (is_null($auth) and self::hasAuthCookies()) or
            $auth
        ) {
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

    private static function client($auth = null)
    {
        $headers = self::getHeaders($auth);

        return new  \GuzzleHttp\Client([
            'base_uri' => config('gameserverapp.connection.url'),
            'headers'  => $headers,
            'timeout' => config('gameserverapp.connection.timeout'),
            'verify' => !app()->environment(['local', 'dev', 'test'])
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