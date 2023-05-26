<?php

namespace App\Service\Validators;

use InvalidArgumentException;

class EmailValidator implements ValidatorInterface
{
    public function validate(mixed $data): void
    {
        if (!filter_var($data, FILTER_VALIDATE_EMAIL))
            throw new InvalidArgumentException(
                "\"$data\" is incorrect email"
            );
    }
}