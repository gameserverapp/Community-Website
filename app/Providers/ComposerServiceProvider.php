<?php

namespace App\Providers;

use GameserverApp\Composers\PanelsDonationTarget;
use GameserverApp\Composers\PanelsLastDonations;
use GameserverApp\Composers\PanelsTop5Donors;
use GameserverApp\Composers\PanelsTop5Voters;
use GameserverApp\Composers\ShopPack;
use GameserverApp\Composers\SupporterTier;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use GameserverApp\Composers\ActiveTribes;
use GameserverApp\Composers\HoursPlayedLast7Days;
use GameserverApp\Composers\LastOnline;
use GameserverApp\Composers\LatestForumActivity;
use GameserverApp\Composers\LatestNewsUpdates;
use GameserverApp\Composers\Newbies;
use GameserverApp\Composers\NewPlayersLast7Days;
use GameserverApp\Composers\OnlineCountLast7Days;
use GameserverApp\Composers\PanelsLast5FreshSurvivors;
use GameserverApp\Composers\PanelsTop5Characters;
use GameserverApp\Composers\PanelsWhosOnline;
use GameserverApp\Composers\PopulationOverview;
use GameserverApp\Composers\ServerSlider;
use GameserverApp\Composers\Spotlight;
use GameserverApp\Composers\TopPlayers;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        $this->pagebuilderBlocks();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function pagebuilderBlocks()
    {
        $composers = [
            'panels_top_5_characters'       => PanelsTop5Characters::class,
            'panels_whos_online'            => PanelsWhosOnline::class,
            'panels_last_5_fresh_survivors' => PanelsLast5FreshSurvivors::class,
            'panels_top_voters'             => PanelsTop5Voters::class,
            'panels_top_donors'             => PanelsTop5Donors::class,
            'panels_last_donations'         => PanelsLastDonations::class,
            'panels_donation_target'        => PanelsDonationTarget::class,

            'latest_forum_activity' => LatestForumActivity::class,
            'latest_news_updates'   => LatestNewsUpdates::class,
            'server_slider'         => ServerSlider::class,
            'server_block'          => ServerSlider::class,
            'spotlight'             => Spotlight::class,
            'active_tribes'         => ActiveTribes::class,
            'newbies'               => Newbies::class,
            'top_players'           => TopPlayers::class,
            'last_online'           => LastOnline::class,
            'population_overview'   => PopulationOverview::class,

            'supporter_tier' => SupporterTier::class,
            'shop_pack' => ShopPack::class
        ];

        foreach ($composers as $view => $composer) {
            View::composer('pagebuilder.v1.blocks.' . $view, $composer);
        }
    }
}