<?php

namespace App\Interfaces\Document;

interface IDocumentoRepository 
{
    public function allDocument(array $params);

    public function create(array $params);
    
    public function update(array $params, int $id);

    public function findByUuid(string $uuid);

    public function findById(int $id);

    public function delete(int $id);

    public function updateFile($file, $dir);

    public function active(int $id);
}