<?php

namespace App\Console\Commands;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Console\Command;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\PremiumHostedHelper;

class SetupCommunityWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup-community-website';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs installer to populate .env file';


    public function handle()
    {
        $id = trim($this->ask('Enter your Client ID from GameServerApp.com'));
        $secret = trim($this->ask('Enter your Client Secret from GameServerApp.com'));
        $domain = trim($this->ask('Enter the domain for your website (without HTTP or HTTPS)'));

        $client = new \GuzzleHttp\Client([
            'base_uri' => config('gameserverapp.connection.url'),
            'headers' => [
                'X-AUTH-GSA-CLIENT-ID' => $id
            ]
        ]);

        try {
            $response = $client->get('domain/settings');

            $response = json_decode($response->getBody());

            if(!isset($response->name)) {
                throw new \Exception('Could not find "name"');
            }

        } catch(\Exception $e) {
            $this->error('Your API keys appear to be incorrect. Make sure to copy the keys and make sure there are no spaces in the key.');
            $this->error('Please try again');
            return $this->call('setup-community-website');
        }

        if(!file_exists($this->laravel->environmentFilePath())) {
            $content = file_get_contents($this->laravel->environmentFilePath() . '.example');
            file_put_contents($this->laravel->environmentFilePath(), $content);
        }

        $this->writeNewEnvironmentFileWith('GSA_CLIENT_ID', $id);
        $this->writeNewEnvironmentFileWith('GSA_CLIENT_SECRET', $secret);
        $this->writeNewEnvironmentFileWith('GSA_REDIRECT_URL', 	'https://' . $domain . '/auth/callback');

        $this->writeNewEnvironmentFileWith('CACHE_DRIVER', 	'redis');
        $this->writeNewEnvironmentFileWith('REDIS_HOST', 	'127.0.0.1');

        $content = file_get_contents(base_path('scripts/install-ssl.sh'));
        $content = str_replace('%%DOMAIN%%', $domain, $content);
        file_put_contents('/var/www/install-ssl.sh', $content);

        $this->call('key:generate');

        $this->info('Almost ready! Setup the custom domain for your website on the GameServerApp.com dashboard.');
    }

    protected function writeNewEnvironmentFileWith($key, $value)
    {
        $content = file_get_contents($this->laravel->environmentFilePath());

        if(!empty($content) and strpos($content, $key) === false) {
            $content .= "\n" . $key . '=' . $value;
        } else {
            $content = preg_replace(
                '/^' . $key . '=(.*)/m',
                $key . '=' . $value,
                $content
            );
        }

        file_put_contents($this->laravel->environmentFilePath(), $content);
    }
}
