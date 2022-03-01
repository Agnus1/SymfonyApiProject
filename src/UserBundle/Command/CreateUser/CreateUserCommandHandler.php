<?php

namespace App\UserBundle\Command\CreateUser;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserCommandHandler implements MessageHandlerInterface
{
    private UserRepository $repository;
    private UserPasswordHasherInterface $hasher;
    private RoleRepository $roleRepository;

    public function __construct(
        UserRepository $repository,
        UserPasswordHasherInterface $hasher,
        RoleRepository $roleRepository
    )
    {
        $this->repository = $repository;
        $this->hasher = $hasher;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param CreateUserCommand $command
     * @return void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(CreateUserCommand $command)
    {
        $user = new User();
        $user->setFullName($command->getFullName())
            ->setUsername($command->getLogin())
            ->setEmail($command->getEmail())
            ->setIsActive($command->getIsActive())
            ->setPassword($this->hasher->hashPassword($user, $command->getPassword()))
            ->setRole($this->roleRepository->getDefaultRole());
        $this->repository->add($user);
    }
}