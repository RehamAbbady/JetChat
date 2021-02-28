<?php
use Slim\App;

/**
 * get middleware settings from settings file
 */
return function (App $app){
    $setting=$app->getContainer()->get('settings');
    $app->addErrorMiddleware(
        $setting['displayErrorDetails'],
        $setting['logErrors'],
        $setting['logErrorDetails']
    );
};