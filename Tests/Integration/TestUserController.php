<?php

namespace Tests\Integration;

use App\Library\Http\HttpCode;
use App\Models\User;
use Tests\FunctionalTestCase;

class TestUserController extends FunctionalTestCase
{
    public function testCreateUser_shouldReturnMutation_whenValidDataIsReceived()
    {
        $user = new User( [
            "firstName" => "Ulises",
            "lastName" => "Familia Rodriguez",
            "email" => "chicromedia@hotmail.com",
            "password" => "12345678",
            "birthday" => "1987-09-16"
        ] );

        $this->sendPost( "/users/create", [ "body" => $user ] );

        $this->assertResponseCode( HttpCode::CREATED );
        $this->assertIsObject( $this->getJsonBody() );
        $this->assertResponseContentContains( "\"id\":1" );
        $this->assertResponseContentContains( "\"firstName\":\"Ulises\"" );
        $this->assertResponseContentContains( "\"lastName\":\"Familia Rodriguez\"" );
        $this->assertResponseContentContains( "\"email\":\"chicromedia@hotmail.com\"" );
        $this->assertResponseContentContains( "\"password\":null" );
    }

    public function testCreateUser_shouldReturnBadRequest_whenInvalidEmailIsReceived()
    {
        $user = new User( [
            "firstName" => "Ulises",
            "lastName" => "Familia Rodriguez",
            "email" => "chicromedia@hot",
            "password" => "12345687",
            "birthday" => "1987-09-16"
        ] );

        $this->sendPost( "/users/create", [ "body" => $user ] );

        $this->assertResponseCode( HttpCode::BAD_REQUEST );
        $this->assertIsObject( $this->getJsonBody() );
        $this->assertResponseContentContains( "\"field\":\"email\"" );
        $this->assertResponseContentContains( "\"message\":\"The e-mail is not valid\"" );
    }

    public function testUpdateUser_shouldReturnMutation_whenValidDataIsReceived()
    {
        $user = new User( [
            "firstName" => "Ulises",
            "lastName" => "Familia",
            "email" => "chicromedia@hotmail.com",
            "password" => "12345678",
            "birthday" => "1987-09-16"
        ] );
        $user->create();
        $user->lastName = "Familia Rodriguez";

        $this->sendPut( "/users/update", [ "body" => $user ] );

        $this->assertResponseCode( HttpCode::OK );
        $this->assertIsObject( $this->getJsonBody() );
        $this->assertResponseContentContains( "\"id\":1" );
        $this->assertResponseContentContains( "\"firstName\":\"Ulises\"" );
        $this->assertResponseContentContains( "\"lastName\":\"Familia Rodriguez\"" );
        $this->assertResponseContentContains( "\"email\":\"chicromedia@hotmail.com\"" );
        $this->assertResponseContentContains( "\"password\":null" );
    }

    public function testUpdateUser_shouldReturnBadRequest_whenInValidPasswordIsReceived()
    {
        $user = new User( [
            "firstName" => "Ulises",
            "lastName" => "Familia",
            "email" => "chicromedia@hotmail.com",
            "password" => "12345",
            "birthday" => "1987-09-16"
        ] );
        $user->create();
        $user->lastName = "Familia Rodriguez";

        $this->sendPut( "/users/update", [ "body" => $user ] );

        $this->assertResponseCode( HttpCode::BAD_REQUEST );
        $this->assertIsObject( $this->getJsonBody() );
        $this->assertResponseContentContains( "\"field\":\"password\"" );
        $this->assertResponseContentContains( "\"message\":\"The password is not valid\"" );
    }

    public function testDeleteUser_shouldReturnOk_whenItUserExists()
    {
        $user = new User( [
            "firstName" => "Ulises",
            "lastName" => "Familia",
            "email" => "chicromedia@hotmail.com",
            "password" => "12345678",
            "birthday" => "1987-09-16"
        ] );
        $user->create();

        $this->sendDelete( "/users/delete/{$user->id}" );

        $this->assertResponseCode( HttpCode::OK );
        $this->assertIsObject( $this->getJsonBody() );
        $this->assertResponseContentContains( "\"success\":true" );
    }

    public function testDeleteUser_shouldReturnNotFound_whenItNotUserExists()
    {
        $user = (object)[ "id" => 1 ];

        $this->sendDelete( "/users/delete/{$user->id}" );

        $this->assertResponseCode( HttpCode::NOT_FOUND );
        $this->assertIsObject( $this->getJsonBody() );
        $this->assertResponseContentContains( "\"message\":\"The user not found\"" );
    }
}
