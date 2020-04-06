<?php

namespace App\Console\Commands;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Console\Command;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\PremiumHostedHelper;

class WarmCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call heavy API calls, to warm the cache';
    /**
     * @var Client
     */
    private $client;

    /**
     * Create a new command instance.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;

        $this->warm = [
            'allServers' => [true, false],
            'characters' => ['top', 'fresh', 'online'],
            'spotlight' => 'character',
            'domain',
            'latestForumThreads',
            'latestNews'
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $domains = PremiumHostedHelper::getActiveDomains();
        } catch(\Exception $e) {
            if($e->getCode() == 503) {
                return;
            }

            if(!env('PREMIUM_GUI_API_DOMAIN_ENDPOINT', false)) {
                return $this->warmSelfHosted();
            }

            Bugsnag::notifyException($e);
        }

        if(!isset($domains) or !$domains) {
            return;
        }

        foreach($domains as $domain) {
            config([
                'gameserverapp.oauthapi_domain' => $domain,
                'gameserverapp.oauthapi_allow_cache' => false
            ]);

            $this->info('Processing ' . $domain);
            $this->warm($this->warm);

            $this->info('Cache warmed for ' . $domain);
        }
    }

    private function warmSelfHosted()
    {
        $this->info('Processing self-hosted');
        $this->warm($this->warm);

        $this->info('Cache warmed for self-hosted');
    }

    private function warm(Array $callables)
    {
        foreach($callables as $callable => $args) {

            if(is_numeric($callable)) {
                $callable = $args;
                $args = null;
            }

            if(is_array($args)) {
                foreach($args as $arg) {
                    $this->callMethod($callable, $arg);
                }

                continue;
            }

            $this->callMethod($callable, $args);
        }

        try {
            $this->client->stats('domain', 'new-characters');
            $this->client->stats('domain', 'online-players');
            $this->client->stats('domain', 'hours-played');
        } catch( \Exception $e) {
            Bugsnag::leaveBreadcrumb('Domain: ' . config('gameserverapp.oauthapi_domain'));
            Bugsnag::notifyException($e);
        }
    }

    private function callMethod($method, $args)
    {
        if(method_exists($this->client, $method)) {
            try {
                $this->info(' - warmed "' . $method . '"');
                return $this->client->$method($args);
            } catch (\Exception $e) {

            }
        }
    }
}
