<?php
use Slim\App;
use \App\Http\Controllers\MessageController;
use \App\Http\Controllers\ChatController;



return function (App $app){

    /**
     * get messages route
     * lastReadMessageId and limit are optional
     * receiverId must be the current logged in user id
     */
    $app->get('/api/message/get/{receiverId}[/{lastReadMessageId}[/{limit}]]', [MessageController::class,'getMessage']);
    /**s
     * send messages route
     */
    $app->post('/api/message/send', [MessageController::class,'sendMessage']);


};

