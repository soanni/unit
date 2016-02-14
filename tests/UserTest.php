<?php

namespace tests;

use src\User;

require_once('../src/User.php');

/**
 * Class UserTest
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        $this->user = new User(array('firstName' => 'FirstName','lastName' => 'LastName','email' => 'test@example.com','password' => 'password123'));
    }

    public function testValidInput(){
        $this->assertTrue($this->user->isInputValid());
        $this->user->email = null;
        $this->assertFalse($this->user->isInputValid());
    }

    public function testInValidInput(){
        $this->user->email = null;
        $this->assertFalse($this->user->isInputValid());
    }

    public function testCreatedPassword(){
        $this->user->createPassword();
        $this->assertEquals(sha1('password123'.$this->user->salt),$this->user->password);
        $this->assertNotEquals(sha1(null),$this->user->password);
    }

    public function testEmptyPassword(){
        $this->user->createPassword();
        $this->assertNotEquals(sha1(null),$this->user->password);
    }

    public function testValidPassword(){
        $this->user->createPassword();
        $this->assertTrue($this->user->verifyPassword('password123'));
    }

    public function testInvalidPassword(){
        $this->user->createPassword();
        $this->assertFalse($this->user->verifyPassword(null));
    }
}
