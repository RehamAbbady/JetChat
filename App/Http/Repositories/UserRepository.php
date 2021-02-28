<?php


namespace App\Http\Repositories;


use App\lib\Core;
use App\Models\User;
use PDO;
use PDOException;

/**
 * Class UserRepository
 *
 * This class is a middleware between authorization and validation helpers and the database
 * it gets user info from the database and pass it to the helpers
 *
 * @author  Reham Abbady
 */
class UserRepository
{
    /**
     * core object
     *
     * @var Core $core
     */
    private $core;

    /**
     * create a core instance in constructor to initiate database connection
     */
    function __construct()
    {
        $this->core = Core::getInstance();
    }

    /**
     * @param string $username
     * @return mixed
     * this method takes the username as a parameter and returns user object
     * if the user doesn't exist in the database,it returns null
     *
     */
    public function getUserToken($username)
    {

        $getToken = "SELECT token,id FROM user WHERE username= :username";
        try {
            $stmt = $this->core->dbh->prepare($getToken);
            $stmt->bindParam(':username', $username);

            $stmt->execute();

            $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($record)) {
                $user = new User($record[0]['id'],$username,$record[0]['token']);
                return $user;
                }
            else{
                return null;
            }

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    /**
     * @param int $userId
     * @return int
     * this method checks if the given user id is in the database
     *if the user exists, it returns  1
     * if not, it returns 0
     */

    public function checkIfUserExists($userId)
    {

        $getToken = "SELECT EXISTS(SELECT 1 FROM user where id=:userId) as exist";
        try {
            $stmt = $this->core->dbh->prepare($getToken);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['exist'];

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
