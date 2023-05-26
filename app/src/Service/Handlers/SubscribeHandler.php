<?php

namespace App\Service\Handlers;

use App\Exceptions\NonUniqueData;
use App\Repository\Repository;
use InvalidArgumentException;

class SubscribeHandler
{
    public function __construct(
        protected Repository $repository,
        protected string     $fileFullPath
    )
    {
    }

    /**
     * @throws NonUniqueData
     * @throws InvalidArgumentException
     */
    public function handle(string $email): void
    {
        if (!file_exists($this->fileFullPath) || !$this->repository->has($email)) {
            $this->repository->save($email);
        } else {
            throw new NonUniqueData("Email \"$email\" already exists");
        }
    }
}