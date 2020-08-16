The GameServerApp.com community website has all the basics setup for you, so you can focus on the details and custom design.

You can use the GSA pagebuilder, or setup your custom HTML webpages. The Community website is build on top of the [Laravel framework](https://laravel.com/docs/5.4).

You can find all assets (js & css) files in `/resources/assets/`. The JS & CSS files in the public dir should NOT be used to customize. 

After making changes to the assets, please run `npm run production`. Or have gulp compile the assets for you after each change automatically: `npm run watch`.

# Set up the community website

In the wiki you can find a walk-through guide on how to [install the community website on your own Digital Ocean server](https://github.com/GameserverApp/Community-Website/wiki/Digital-Ocean-droplet-setup). You can skip the steps below if you choose this option.

## Install

Rename `.env.example` to `.env`. Change the parameters in the `.env` to your GSA OAuth API keys as shown on your [API settings page](https://github.com/GameserverApp/community-website). 

### Command line installation
Now we need to run a couple commands. Navigate into the project root.
We recommend using NodeJS v11.15.0 & NPM 6.7.0.

```@cli
$ composer install
```

This project uses Gulp to build the assets. You can run it once with `npm run production` or for development purposes with `npm run watch`.

If you are deploying your code to your webserver, we suggest you run the following commands in the web root:

```@cli
composer install --no-interaction --no-dev --prefer-dist
php artisan down
npm install --loglevel=error
npm run production
chown -R www-data:www-data ./*
php artisan up
```

# Issues
If you experience any (security) issues, please contact support@gameserverapp.com.

## License

The Community website is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).