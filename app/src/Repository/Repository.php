<?php

namespace App\Repository;

interface Repository
{
    public function all(): array;
    public function save(mixed $data);
    public function has(mixed $needle): bool;
}