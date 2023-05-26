<?php

namespace App\Service\Validators;

use InvalidArgumentException;

interface ValidatorInterface
{
    /**
     * @param mixed $data
     * @return void
     * @throws InvalidArgumentException
     */
    public function validate(mixed $data): void;
}