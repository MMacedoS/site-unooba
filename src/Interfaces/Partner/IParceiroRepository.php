<?php

namespace App\Interfaces\Partner;

interface IParceiroRepository 
{
    public function allPartner(array $params);

    public function create(array $params);
    
    public function update(array $params, int $id);

    public function findByUuid(string $uuid);

    public function findById(int $id);

    public function delete(int $id);

    public function updatePhoto($file, $dir, $id_user);

    public function active(int $id);
}