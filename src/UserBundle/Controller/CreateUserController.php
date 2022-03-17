<?php

namespace App\UserBundle\Controller;

use App\Common\CQRS\CommandBusInterface as CommandBus;
use App\Common\Services\JsonParamFetcher;
use App\Common\Services\ParamFetcherInterface;
use App\UserBundle\Command\CreateUser\CreateUserCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class CreateUserController
{
    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;
    private LoggerInterface $logger;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->logger = $logger;
    }

    /**
     * @Route("/api/users", methods={"POST"})
     */
    public function createUser(Request $request, ParamFetcherInterface $fetcher) : JsonResponse
    {
        $fetcher->setContent($request->getContent());
        $params = $fetcher->getParams();
        
        $command = new CreateUserCommand($params["login"], $params["password"], $params["fullname"]);
        $id = $this->commandBus->dispatch($command);

        $logger->info(date("d.m.y h:i:s") . " Created User: " . $id);
        return new JsonResponse(
            [
                "id" => $id,
                "status" => "OK",
                "code" => Response::HTTP_OK
            ],
            Response::HTTP_OK);
    }
}