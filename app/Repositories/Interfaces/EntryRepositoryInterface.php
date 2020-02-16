<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface EntryRepositoryInterface
{
    public function all();
    public function get($id);
    public function filter(array $criteria);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function copy($id);
    public function deleteAll();
    // eleasticsearch functions
    public function index();
    public function indexExists();
    public function search($query);
}
