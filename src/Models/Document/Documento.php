<?php

namespace App\Models\Document;

use App\Controllers\v1\Traits\GenericTrait;
use App\Models\File\Arquivo;
use App\Models\Traits\UuidTrait;

class Documento {
    
    use UuidTrait;
    use GenericTrait;

    public $id;
    public string $uuid;
    public string $nome;
    public string $ativo;
    public ?string $arquivo_id;
    public $arquivo;
    public $created_at;
    public $updated_at;

    public function __construct () {}

    public function create(
        array $data
    ): Documento {
        $documento = new Documento();
        $documento->id = $data['id'] ?? null;
        $documento->uuid = $data['uuid'] ?? $this->generateUUID();
        $documento->nome = $this->formatName($data['name']);
        $documento->arquivo_id = $data['file_id'] ?? null;
        $documento->ativo = (int)$data['active'] ?? 1; 
        $documento->created_at = $data['created_at'] ?? null;
        $documento->updated_at = $data['updated_at'] ?? null;
        return $documento;
    }

    public function update(array $data, Documento $documento): Documento
    {
        $documento->nome = isset($data['name']) ? $this->formatName($data['name']) : $documento->nome;
        $documento->arquivo_id = $data['file_id'] ?? $documento->arquivo_id;
        $documento->ativo = $data['active'] ?? $documento->ativo;

        return $documento;
    }
}