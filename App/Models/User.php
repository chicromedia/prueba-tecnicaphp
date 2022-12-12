<?php

namespace App\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\StringLength\Min as MinStringLengthValidator;

/**
 * @method static User|null findFirstById( int $id )
 */
class User extends Model
{
    const STATUS_ACTIVE   = "active";
    const STATUS_INACTIVE = "inactive";
    const STATUS_BANNED   = "banned";

    public ?int    $id        = null;
    public string  $username;
    public string  $firstName;
    public string  $lastName;
    public ?string $birthday  = null;
    public string  $email;
    public string  $gender;
    public ?string $password;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;
    public ?string $status    = null;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource( "user" );
    }

    /**
     * Validations and business logic
     * @return boolean
     */
    public function validation(): bool
    {
        $validator = new Validation();

        $validator->add( 'email', new EmailValidator( [
            'message' => 'The e-mail is not valid',
        ] ) );

        $validator->add( 'password', new MinStringLengthValidator( [
            'min' => 8,
            'message' => 'The password is not valid',
        ] ) );

        return $this->validate( $validator );
    }

    /**
     * @param $parameters
     * @return User[]|ResultsetInterface
     */
    public static function find( $parameters = null ): ResultsetInterface
    {
        return parent::find( $parameters );
    }

    /***
     * @param $parameters
     * @return User|ModelInterface|null
     */
    public static function findFirst( $parameters = null ): ?ModelInterface
    {
        return parent::findFirst( $parameters );
    }

}
