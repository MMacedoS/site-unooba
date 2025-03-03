<?php

namespace App\Interfaces\Page;

interface IPaginaRepository 
{
    public function allPages(array $params);

    public function create(array $params);
    
    public function update(array $params, int $id);

    public function findByUuid(string $uuid);

    public function findById(int $id);

    public function delete(int $id);

    public function addPhoto($file, $dir, $id_user);

    public function page(array $params);

    public function active(int $id);
}