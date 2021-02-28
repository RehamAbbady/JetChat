<?php


namespace App\Models;

/**
 * Class User
 * @package App\Models
 *
 * @author  Reham Abbady
 */
class User
{
    private $id;
    private $username;
    private $token;

    /**
     * User constructor.
     * @param $id
     * @param $username
     * @param $token
     */
    public function __construct($id, $username, $token)
    {
        $this->id = $id;
        $this->username = $username;
        $this->token = $token;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }


}