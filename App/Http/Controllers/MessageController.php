<?php


namespace App\Http\Controllers;


use App\Http\Helpers\AuthHelper;
use App\Http\Helpers\InputValidationHelper;
use App\Http\Helpers\ResponseHelper;
use App\Models\Message;
use App\Http\Repositories\MessageRepository;
use Psr\Http\Message\ServerRequestInterface as Request;
/**
 * Class MessageController
 *
 * message controller is responsible for handling the API's reqests
 *
 * @author  Reham Abbady
 */
class MessageController
{
    /**
     *
     * @var AuthHelper $authHelper
     * @var MessageRepository  $messageRepository
     * @var ResponseHelper $responseHelper
     * @var InputValidationHelper $inputValidationHelper
     * @const int LIMIT_DEFAULT
     * @const int LAST_READ_MESSAGE_ID
     *
     */
    private $authHelper;
    private $messageRepository;
    private $responseHelper;
    private $inputValidationHelper;
    private const LIMIT_DEFAULT = 50;
    private const LAST_READ_MESSAGE_ID = 0;


    /**
     * @param AuthHelper $authHelper
     * @param MessageRepository  $messageRepository
     * @param ResponseHelper $responseHelper
     * @param InputValidationHelper $inputValidationHelper
     * @param int LIMIT_DEFAULT
     * @param int LAST_READ_MESSAGE_ID
     *
     */
    function __construct(AuthHelper $authHelper, MessageRepository $messageRepository, ResponseHelper $responseHelper, InputValidationHelper $inputValidationHelper)
    {
        $this->authHelper = $authHelper;
        $this->messageRepository = $messageRepository;
        $this->responseHelper = $responseHelper;
        $this->inputValidationHelper = $inputValidationHelper;

    }

    /**
     * @param Request $request
     *
     *this method takes a request object and gets the message body
     *and pass and validates the user and the input
     * if valid, message is inserted in the db
     *
     */
    public function sendMessage(Request $request)
    {

        $decodedObj = json_decode($request->getBody());
        if ($decodedObj === null) {
            $this->responseHelper->response('400', "wrong input format");

        }

        $message = new Message();
        $message->setSenderId($decodedObj->message[0]->senderId) ;
        $message->setReceiverId($decodedObj->message[0]->receiverId);
        $message->setMessageContent($decodedObj->message[0]->messageContent);
        $message->setDateSent( $decodedObj->message[0]->dateSent);
        $auth = $this->authHelper->authorizeSendMessage($message->getSenderId());
        //if user is authenticated, validate input
        if ($auth==true) {

            $validateInput = $this->inputValidationHelper->validateSentMessage($message);
            //if input is valid, send message
            if ($validateInput) {
                $dbResult = $this->messageRepository->sendMessage($message);
                if ($dbResult != 0) {
                    $this->responseHelper->response('200', "message sent");
                } else {
                    $this->responseHelper->response('500', "failed to send message");
                }

            }

        }

    }
    /**
     * @param int $receiverId
     * @param int $lastReadMessageId
     * @param int $limit
     *
     *this method takes reveiverId(current user)
     * and validates if the current logged in user has the same receiver id as the one passed to the method
     * if it is, get the messages with the same receiver id from the db with optional parameters
     * $lastReadMessageId and limit which is the number of returned messages
     *
     *
     */
    public function getMessage($receiverId, $lastReadMessageId = self::LAST_READ_MESSAGE_ID, $limit = self::LIMIT_DEFAULT)
    {


        $auth = $this->authHelper->authorizeGetMessage($receiverId);
        if ($auth == 1) {
            //$messageRepository = new MessageRepository();
            $dbResult = $this->messageRepository->getMessage($receiverId, $lastReadMessageId, $limit);
            $this->responseHelper->response('200', $dbResult);

        }

    }


}