<?php
use \Psr\Container\ContainerInterface;
/**
 * set middleware settings
 */
return function(ContainerInterface $container){
    $container->set('settings',function(){
        return [
            'displayErrorDetails'=>true,
            'logErrorDetails'=>true,
            'logErrors'=>true

            ];
    });

};