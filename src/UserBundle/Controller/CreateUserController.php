<?php

namespace App\UserBundle\Controller;

use App\Common\CQRS\CommandBusInterface as CommandBus;
use App\UserBundle\Command\CreateUser\CreateUserCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateUserController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/api/users", methods={"GET"})
     */
    public function createUser(Request $request) : JsonResponse
    {
        $command = new CreateUserCommand('testLogin', 'password', 'IgorKim');
        $this->commandBus->dispatch($command);
        return new JsonResponse("im working!~", Response::HTTP_OK);
    }
}