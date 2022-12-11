<?php

namespace App\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

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
            'model' => $this,
            'message' => 'Please enter a correct email address',
        ] ) );

        return $this->validate( $validator );
    }
}
