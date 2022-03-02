<?php

namespace App\Common\Exceptions;


abstract class ApiException extends \Exception
{
    /**
     * @var
     */
    protected $errorBag;

    public function __construct(string $message = "", int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param array $errorBag
     * @return $this
     */
    public function setErrorBag(array $errorBag = [])
    {
        $this->errorBag = $errorBag;
        return $this;
    }

    /**
     * @return array
     */
    public function getErrorBag() : array
    {
        return $this->errorBag;
    }
}