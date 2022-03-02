<?php

namespace App\Common\CQRS;

interface CommandBusInterface
{
    /**
     * @param CommandInterface $command
     * @return mixed
     */
    public function dispatch(CommandInterface $command) : mixed;
}