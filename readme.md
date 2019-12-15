To install this website, you need to have access to the command line. You should have [Composer](https://getcomposer.org/download/) and [NPM](https://www.npmjs.com/get-npm) installed. 

If you are unfamiliar with back-end and hosting stuff, but do know how to do front-end work, please follow this guide to setup a simple GSA Community website with Digital Ocean.

## Download

Navigate to `/var/www` on your webserver and execute command below:

`git clone git@github.com:GameserverApp/community-website.git`

or download the source code as a zip and upload it to your webserver.

## Install

Rename `.env.example` to `.env` and edit it.

Change the parameters in the `.env` to your GSA OAuth API keys as shown on your [API settings page](https://github.com/GameserverApp/community-website). 

### Command line installation
Now we need to run a couple commands. Navigate into the project root.

```@cli
$ composer install
$ npm install
```