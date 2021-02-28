<?php


namespace App\Http\Helpers;


use App\Http\Repositories\UserRepository;
use App\Models\Message;

/**
 * Class InputValidationHelper
 *
 * this class handles the validation of incoming requests
 *
 * @author  Reham Abbady
 */
class InputValidationHelper
{/**
 *
 * @var ResponseHelper $responseHelper
 * @var UserRepository $userRepository
 *
 */
    private $responseHelper;
    private $userRepository;

    /**
     * @param ResponseHelper $responseHelper
     * @param UserRepository $userRepository
     *
     *
     */
    function __construct(ResponseHelper $responseHelper, UserRepository $userRepository) {
        $this->responseHelper=$responseHelper;
        $this->userRepository=$userRepository;
    }

    /**
     * @param Message $message
     * @return boolean
     *this method validate the sent message object
     * if it is not valid, it responds with 400 bad request
     * if it is valid, it returns true
     */
    public function validateSentMessage(Message $message){

        //check if any of the input is an empty string or white space
        if(trim($message->getMessageContent())==""||trim($message->getDateSent())==""||trim($message->getReceiverId())==""||trim($message->getSenderId())==""){
            $this->responseHelper->response('400','missing input');

        }

        //check if receiver id exists in db
        $result=$this->userRepository->checkIfUserExists($message->getReceiverId());
        if($result==0){
           $this->responseHelper->response('400','invalid receiver id');

        }
        //check if sender id= receiver id
        if($message->getSenderId()==$message->getReceiverId()){
            $this->responseHelper->response('400',"can't send a message to yourself");

        }
        //check if date format is valid
        $format='d-m-Y H:i:s';
        $validateDate=\DateTime::createFromFormat($format, $message->getDateSent());
        if(!$validateDate){
            $this->responseHelper->response('400','wrong date format');

        }

        return true;


    }

}