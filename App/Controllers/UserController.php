<?php

namespace App\Controllers;

use App\Library\Http\HttpCode;
use App\Library\Repositories\UserRepository;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Controller;

/**
 * @property UserRepository $userRepository
 */
class UserController extends Controller
{
    /**
     * @return ResponseInterface
     */
    public function create(): ResponseInterface
    {
        $user   = $this->request->getPost();
        $entity = $this->userRepository->create( $user );

        if ( !!$entity->id )
        {
            $entity->password = null;
            $this->response->setStatusCode( HttpCode::CREATED );
            $this->response->setJsonContent( $entity->toArray() );
        } else
        {
            [ $firstError ] = $entity->getMessages();
            $this->response->setStatusCode( HttpCode::BAD_REQUEST );
            $this->response->setJsonContent( $firstError );
        }

        return $this->response;
    }

    public function update()
    {
        $user   = $this->request->getPut();
        $entity = $this->userRepository->save( $user );

        if ( !!$entity->id )
        {
            $entity->password = null;
            $this->response->setStatusCode( HttpCode::OK );
            $this->response->setJsonContent( $entity->toArray() );
        } else
        {
            [ $firstError ] = $entity->getMessages();
            $this->response->setStatusCode( HttpCode::BAD_REQUEST );
            $this->response->setJsonContent( $firstError );
        }

        return $this->response;
    }

    public function delete( int $id )
    {
        $deleted = $this->userRepository->delete( $id );

        if ( !!$deleted )
        {
            $this->response->setStatusCode( HttpCode::OK );
            $this->response->setJsonContent( [ "success" => true ] );
        } else
        {
            $this->response->setStatusCode( HttpCode::NOT_FOUND );
            $this->response->setJsonContent( [ "message" => "The user not found" ] );
        }

        return $this->response;
    }
}
