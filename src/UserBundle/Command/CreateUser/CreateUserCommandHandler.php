<?php

namespace App\UserBundle\Command\CreateUser;

use App\Common\Exceptions\ValidationException;
use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateUserCommandHandler implements MessageHandlerInterface
{
    private UserRepository $repository;
    private UserPasswordHasherInterface $hasher;
    private RoleRepository $roleRepository;
    private ValidatorInterface $validator;

    /**
     * @param UserRepository $repository
     * @param UserPasswordHasherInterface $hasher
     * @param RoleRepository $roleRepository
     * @param ValidatorInterface $validator
     */
    public function __construct(
        UserRepository $repository,
        UserPasswordHasherInterface $hasher,
        RoleRepository $roleRepository,
        ValidatorInterface $validator,
    )
    {
        $this->repository = $repository;
        $this->hasher = $hasher;
        $this->roleRepository = $roleRepository;
        $this->validator = $validator;
    }

    /**
     * @param CreateUserCommand $command
     * @return void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(CreateUserCommand $command) : int
    {
        $user = new User();
        $user->setFullName($command->getFullName())
            ->setUsername($command->getLogin())
            ->setEmail($command->getEmail())
            ->setPassword($this->hasher->hashPassword($user, $command->getPassword()))
            ->setRole($this->roleRepository->getDefaultRole());

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $errorsArr[$error->getPropertyPath()] = $error->getMessage();
            }
            throw (new ValidationException())->setErrorBag($errorsArr);
        }

        $this->repository->add($user);
        return $user->getId();
    }
}