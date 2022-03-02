<?php

namespace App\UserBundle\Command;

use App\Common\CQRS\CommandInterface;

abstract class UserCommand implements CommandInterface
{
    private string $login;
    private string $password;
    private string $fullName;
    private ?string $email;
    private bool $isActive;

    /**
     * @param string $login
     * @param string $password
     * @param string $fullName
     * @param string|null $email
     * @param bool $isActive
     */
    public function __construct(
        string $login,
        string $password,
        string $fullName,
        string $email = null,
        bool $isActive = true
    )
    {
        $this->email = $email;
        $this->isActive = $isActive;
        $this->login = $login;
        $this->password = $password;
        $this->fullName = $fullName;
    }


    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public function getIsActive() : bool
    {
        return $this->isActive;
    }

    public function __serialize(): array
    {
        return [
            'login' => $this->getLogin(),
            'password' => $this->getPassword(),
            'isActive' => $this->getIsActive(),
            'email' => $this->getEmail(),
            'fullName' => $this->getFullName(),
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->login = $data['login'];
        $this->password = $data['password'];
        $this->email = $data['email'];
        $this->fullName = $data['fullName'];
    }
}