<?php
/**
 * kort - Webservice\User\UserHandler class
 */
namespace Webservice\User;

use Webservice\DbProxyHandler;
use OAuth\AbstractOAuthCallback;

/**
 * The UserHandler class handles all POST and PUT requests to the user webservice.
 */
class UserHandler extends DbProxyHandler
{
    /**
     * Returns the database table to be used with this Handler.
     *
     * @return the database table as a string
     */
    protected function getTable()
    {
        return 'kort.user';
    }

    /**
     * Returns the database fields to be used with this Handler.
     *
     * @return an array of database fields
     */
    protected function getFields()
    {
        return array(
            'user_id',
            'name',
            'oauth_user_id',
            'username',
            'pic_url',
            'oauth_provider',
            'token',
            'secret'
        );
    }

    /**
     * Return the database fields to return when executing insert or update.
     *
     * @return array of database fields
     */
    protected function getReturnFields()
    {
        return array(
            'user_id',
            'name',
            'username',
            'pic_url',
            'oauth_user_id',
            'secret'
        );
    }

    /**
     * Updates a user with newer data.
     *
     * @param integer $id   The user id.
     * @param array   $data The user data.
     *
     * @return string JSON-encoded updated user
     */
    public function updateUser($id, array $data)
    {
        $this->getDbProxy()->setReturnFields($this->getReturnFields());
        $this->getDbProxy()->setWhere("user_id = " . $id);
        return $this->getDbProxy()->update($data);
    }

    /**
     * Insert a new user.
     *
     * @param array $data The user data.
     *
     * @return string JSON-encoded user
     */
    public function insertUser(array $data)
    {
        $this->getDbProxy()->setReturnFields($this->getReturnFields());
        return $this->getDbProxy()->insert($data);
    }

    /**
     * Verifies a given token and if successful updates the user.
     *
     * @param AbstractOAuthCallback $oauth    An OAuth handler.
     * @param string                $id_token The token to verify.
     *
     * @return boolean|string Returns the user data for authentication if successful, otherwise false
     */
    public function authenticateUser(AbstractOAuthCallback $oauth, $id_token)
    {
        $token = $oauth->verify($id_token);
        if ($token === false) {
            return false;
        }

        $dbUser = $oauth->saveApplicationUser();
        $userData = array();
        $userData['secret'] = $dbUser['secret'];
        $userData['user_id'] = $dbUser['user_id'];

        return json_encode($userData);
    }
}
