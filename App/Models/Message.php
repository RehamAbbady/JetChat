<?php


namespace App\Models;
/**
 * Class Message
 * @package App\Models
 * * @author  Reham Abbady
 *
 */

class Message
{
    private $id;
    private $messageContent;
    private $senderId;
    private $receiverId;
    private $dateSent;

    /**
     * Message constructor.
     *default constructor
     */

    public function __construct()
    {

    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMessageContent()
    {
        return $this->messageContent;
    }

    /**
     * @param mixed $messageContent
     */
    public function setMessageContent($messageContent): void
    {
        $this->messageContent = $messageContent;
    }

    /**
     * @return mixed
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @param mixed $senderId
     */
    public function setSenderId($senderId): void
    {
        $this->senderId = $senderId;
    }

    /**
     * @return mixed
     */
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * @param mixed $receiverId
     */
    public function setReceiverId($receiverId): void
    {
        $this->receiverId = $receiverId;
    }

    /**
     * @return mixed
     */
    public function getDateSent()
    {
        return $this->dateSent;
    }

    /**
     * @param mixed $dateSent
     */
    public function setDateSent($dateSent): void
    {
        $this->dateSent = $dateSent;
    }


}