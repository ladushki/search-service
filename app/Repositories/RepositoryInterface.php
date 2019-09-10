<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface RepositoryInterface
{
    public function getAll(): Collection;
    public function create(array $item);
    public function update(array $item);
    public function exists( array $item): bool;
}