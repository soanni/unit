<?php

namespace tests;

use SebastianBergmann\RecursionContext\InvalidArgumentException;
use src\User;
use src\UserManager;
use util\Mail;
use PHPUnit_Framework_TestCase;

require_once('../src/User.php');
require_once('../src/UserManager.php');
require_once('../util/Mail.php');

/**
 * Class UserManagerTest
 * @package tests
 */
class UserManagerTest extends PHPUnit_Framework_TestCase
{
    public function testCreateUser(){
        $db = new \PDO('mysql:host=localhost;port=3306;dbname=unit','root','jd5xugLMrr');
        $config = new \stdClass();
        $config->email = 'test@example.com';
        $config->site_url = 'http://example.com';

        $user = new User(array('firstName' => 'FirstName','lastName' => 'LastName','email' => 'user@example.com','password' => 'password123'));
        $email = $this->getMock('\util\Mail');

        $userManager = new UserManager($email,$db,$config);
        $this->assertTrue($userManager->createUser($user));
        $this->assertEquals(sha1('password123' . $user->salt),$user->password);
        $this->assertTrue($user->userId > 0);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateUserException(){
        $db = new \PDO('mysql:host=localhost;port=3306;dbname=unit','root','jd5xugLMrr');
        $config = new \stdClass();
        $config->email = 'test@example.com';
        $config->site_url = 'http://example.com';

        $user = new User(array('firstName' => 'FirstName','lastName' => 'LastName','email' => null,'password' => 'password123'));
        $email = $this->getMock('\util\Mail');

        $userManager = new UserManager($email,$db,$config);
        $userManager->createUser($user);
    }
}
