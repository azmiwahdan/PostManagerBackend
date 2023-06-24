<?php

namespace App\Http\services;

use Illuminate\Http\Request;

interface CrudServiceInterface
{
    public function create(Request $data);

    public function update(int $id, Request $data);

    public function delete(int $id);

    public function getById(int $id);

    public function getAll();

}
