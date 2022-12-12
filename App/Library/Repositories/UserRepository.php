<?php

namespace App\Library\Repositories;

use App\Models\User;

class UserRepository extends AbstractRepository
{
    public function __construct() {}

    public function getById( int $id ): ?User
    {
        return User::findFirstById( $id );
    }

    /**
     * @param mixed $user
     * @return User
     */
    public function create( $user ): User
    {
        $entity = new User();
        $entity->assign( (array)$user, [
            "firstName",
            "lastName",
            "email",
            "password",
            "birthday"
        ] );

        if ( $entity->validation() )
        {
            $entity->create();
        }
        return $entity;
    }

    /**
     * @param mixed $user
     * @return User
     */
    public function save( $user ): User
    {
        $entity = new User();
        $entity->assign( (array)$user, [
            "id",
            "firstName",
            "lastName",
            "email",
            "password",
            "birthday"
        ] );

        if ( $entity->validation() )
        {
            $entity->save();
        }
        return $entity;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete( int $id ): bool
    {
        $entity = $this->getById( $id );
        return $entity && $entity->delete();
    }


}
