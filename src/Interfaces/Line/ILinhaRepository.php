<?php

namespace App\Interfaces\Line;

interface ILinhaRepository 
{
    public function allLine(array $params);

    public function create(array $params);
    
    public function update(array $params, int $id);

    public function findByUuid(string $uuid);

    public function findById(int $id);

    public function delete(int $id);

    public function active(int $id);
}