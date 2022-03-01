<?php

namespace App\Common\CQRS;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command);
}