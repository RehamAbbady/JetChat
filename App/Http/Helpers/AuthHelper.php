<?php


namespace App\Http\Helpers;


use App\Http\Repositories\UserRepository;

/**
 * Class AuthHelper
 *
 * This class is responsible for authorizing the user that called the api
 *
 * @author  Reham Abbady
 */
class AuthHelper
{
    /**
     * @var ResponseHelper $responseHelper
     */
    private $responseHelper;

    /**
     * @param ResponseHelper $responseHelper
     *
     *initialize ResponseHelper object in the constructor
     */
    function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    /**
     * @param int $receiverId
     * @return boolean
     * this method takes the receiver Id as a parameter and
     * verifies that the current user is the one that sent the get request
     *
     */
    public function authorizeGetMessage($receiverId)
    {
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
            $this->responseHelper->response('401', "you're not logged in");
        } else {

            $userRepository = new UserRepository();
            $user = $userRepository->getUserToken($_SERVER['PHP_AUTH_USER']);

            if ($user == null) {
                $this->responseHelper->response('401', "wrong username");
            } else {

                if ($user->getId() != $receiverId) {
                    $this->responseHelper->response('401', "your not allowed to get someone else's messages!");
                }

                $password = $_SERVER['PHP_AUTH_PW'];
                $verifyToken = password_verify($password, $user->getToken());
                if ($verifyToken) {
                    return true;
                } else {
                    $this->responseHelper->response('401', "wrong password");
                }

            }
        }

    }

    /**
     * @param int $senderIdFromBody
     * @return boolean
     * this method takes the sender Id as a parameter and
     * verifies that the current user is the one that sent the post request
     *
     */
    public function authorizeSendMessage($senderIdFromBody)
    {
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
            $this->responseHelper->response('401', "you're not logged in");
        } else {
            $userRepository = new UserRepository();
            $user = $userRepository->getUserToken($_SERVER['PHP_AUTH_USER']);


            if ($user == null) {
                $this->responseHelper->response('401', "wrong username");

            } else {

                if ($user->getId() != $senderIdFromBody) {
                    $this->responseHelper->response('401', "sender id does not match your id");
                }

                $password = $_SERVER['PHP_AUTH_PW'];
                $verifyToken = password_verify($password, $user->getToken());
                if ($verifyToken) {
                    return true;
                } else {
                    $this->responseHelper->response('401', "wrong password");
                }

            }
        }

    }


}