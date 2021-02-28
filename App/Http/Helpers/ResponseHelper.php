<?php


namespace App\Http\Helpers;


/**
 * Class ResponseHelper
 *
 * this class handles all responses from the api
 *
 * @author  Reham Abbady
 */

class ResponseHelper
{
    /**
     *
     * @param string $statusCode
     * @param string $responseMessage
     * this method takes the status code and the response passed to it and form a json response
     * and return it to the user
     */


public function response($statusCode,$responseMessage){

    header("HTTP/1.0 ".$statusCode);
    $response = [ 'statusCode' => $statusCode, 'msg' => $responseMessage];
    echo json_encode($response);
    exit;
}

}