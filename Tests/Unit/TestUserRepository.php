<?php

namespace Tests\Unit;

use App\Library\Repositories\UserRepository;
use App\Models\User;
use Tests\ModelTestCase;

class TestUserRepository extends ModelTestCase
{
    private UserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->make( UserRepository::class );
    }

    private function userMock(): array
    {
        return [
            "firstName" => "Ulises",
            "lastName" => "Familia Rodriguez",
            "email" => "chicromedia@hotmail.com",
            "password" => "12345678",
            "birthday" => "1987-09-16",
        ];
    }

    public function testShouldCreate_UseRepository()
    {
        $this->assertInstanceOf( UserRepository::class, $this->repository );
    }

    public function testCreate_shouldReturnUserEntity()
    {
        $user = $this->userMock();

        $expected = $this->repository->create( $user );

        $this->assertInstanceOf( User::class, $expected );
        $this->assertEquals( 1, $expected->id );
        $this->assertEquals( "Ulises", $expected->firstName );
        $this->assertEquals( "Familia Rodriguez", $expected->lastName );
        $this->assertEquals( "chicromedia@hotmail.com", $expected->email );
        $this->assertEquals( "12345678", $expected->password );
        $this->assertEquals( "1987-09-16", $expected->birthday );
    }

    public function testSave_shouldReturnUserEntity()
    {
        $user              = $this->userMock();
        $created           = new User( $user );
        $created->lastName = "Familia";
        $created->create();

        $expected = $this->repository->save( array_merge( [ "id" => $created->id ], $user ) );

        $this->assertInstanceOf( User::class, $expected );
        $this->assertEquals( $created->id, $expected->id );
        $this->assertEquals( "Familia", $created->lastName );
        $this->assertEquals( "Ulises", $expected->firstName );
        $this->assertEquals( "Familia Rodriguez", $expected->lastName );
        $this->assertEquals( "chicromedia@hotmail.com", $expected->email );
        $this->assertEquals( "12345678", $expected->password );
        $this->assertEquals( "1987-09-16", $expected->birthday );
    }
}
