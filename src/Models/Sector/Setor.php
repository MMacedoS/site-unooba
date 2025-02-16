<?php

namespace App\Models\Sector;

use App\Controllers\v1\Traits\GenericTrait;
use App\Models\Traits\UuidTrait;

class Setor {
    
    use UuidTrait;
    use GenericTrait;

    public $id;
    public string $uuid;
    public string $nome;
    public string $ativo;
    public string $ordem;
    public $created_at;
    public $updated_at;

    public function __construct () {}

    public function create(
        array $data
    ): Setor {
        $sector = new Setor();
        $sector->id = $data['id'] ?? null;
        $sector->uuid = $data['uuid'] ?? $this->generateUUID();
        $sector->nome = $this->formatName($data['name']);
        $sector->ordem = (string)$data['order'];
        $sector->ativo = (int)$data['active'] ?? 1; 
        $sector->created_at = $data['created_at'] ?? null;
        $sector->updated_at = $data['updated_at'] ?? null;
        return $sector;
    }

    public function update(array $data, Setor $sector): Setor
    {
        $sector->nome = isset($data['name']) ? $this->formatName($data['name']) : $sector->nome;
        $sector->ordem = $data['order'] ?? $sector->ordem;
        $sector->ativo = $data['active'] ?? $sector->ativo;

        return $sector;
    }
}