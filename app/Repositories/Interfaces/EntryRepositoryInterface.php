<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface EntryRepositoryInterface
{
    public function all(): object;
    public function get($id): ?object;
    public function filter(array $criteria): object;
    public function create(array $data): int;
    public function update($id, array $data): void;
    public function delete($id): void;
    public function copy($id): int;
    public function deleteAll(): void;
    // eleasticsearch functions
    public function index(): void;
    public function indexExists(): int;
    public function search($query): object;
    public function complexSearch($query): object;
}
