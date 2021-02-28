<?php


namespace App\Http\Repositories;


use App\lib\Core;
use App\Models\Message;
use DI\Definition\ArrayDefinition;
use PDO;

/**
 * Class MessageRepository
 *
 * This class is a middleware between Message controller and the database
 * it gets the info from the database and pass it to the controller
 *
 * @author  Reham Abbady
 */
class MessageRepository
{
    /**
     * core objects
     *
     * @var Core $core
     */

    private $core;

    /**
     *
     * create a core instance in constructor to initiate database connection
     */
    function __construct()
    {
        $this->core = Core::getInstance();
    }

    /**
     * @param Message $message message object
     * @return int last inserted id or exception message if an exception happened
     * this method takes a message object as a parameter and add it to the database
     */

    public function sendMessage(Message $message)
    {

        $sql = "INSERT INTO message (content,sender_id,receiver_id,date_sent) VALUES (:content,:sender_id,:receiver_id,:date_sent)";

        try {
            $stmt = $this->core->dbh->prepare($sql);
            $messageContent=$message->getMessageContent();
            $senderId=$message->getSenderId();
            $receiverId=$message->getReceiverId();
            $dateSent=$message->getDateSent();
            $stmt->bindParam(':content', $messageContent);
            $stmt->bindParam(':sender_id', $senderId);
            $stmt->bindParam(':receiver_id', $receiverId);
            $stmt->bindParam(':date_sent', $dateSent);

            $stmt->execute();

            return $this->core->dbh->lastInsertId();

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    /**
     * @param int $receiverId
     * @param int $lastReadMessageId
     * @param int $limit
     * @return mixed
     * this method takes the receiver Id as a parameter and get messages with the same receiver id, and the message id(index) is
     * bigger than the last read message id. sorted from the newest to the oldest
     * the number of returned messages does not exceed the $limit value
     */

    public function getMessage(int $receiverId, int $lastReadMessageId, int $limit)
    {

        $getToken = "SELECT * FROM message WHERE receiver_id= :receiverId AND id> :lastReadMessageId
                    ORDER BY date(date_sent) DESC
                    limit :limit";
        try {
            $stmt = $this->core->dbh->prepare($getToken);
            $stmt->bindParam(':receiverId', $receiverId);
            $stmt->bindParam(':lastReadMessageId', $lastReadMessageId);
            $stmt->bindParam(':limit', $limit);

            $messages = array();
            $message = new Message();

            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $message->setId($row['id']);
                    $message->setSenderId($row['sender_id']);
                    $message->setReceiverId($row['receiver_id']);
                    $message->setMessageContent(['content']);
                    $message->setDateSent( $row['date_sent']);
                    array_push($messages, $row);
                }
                return $messages;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


}