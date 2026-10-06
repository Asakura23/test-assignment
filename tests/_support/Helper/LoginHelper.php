<?php
namespace Helper;

//используем в _before либо в Acceptance хелпере либо непосредственно в нужном тесте

use Codeception\Module;
use Codeception\Module\Db;

class LoginHelper extends \Codeception\Module
{
    public function haveTestUser(string $email, string $password)
    {
        $db = $this->getModule('Db');

        $userData = [
            'email'      => $email,
            'password'   => $password,
            'created' => date('Y-m-d H:i:s'),
        ];

        $db->haveInDatabase('users', $userData);
    }
}