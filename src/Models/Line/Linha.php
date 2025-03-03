<?php

namespace App\Models\Line;

use App\Controllers\v1\Traits\GenericTrait;
use App\Models\Traits\UuidTrait;

class Linha {
    
    use UuidTrait;
    use GenericTrait;

    public $id;
    public string $uuid;
    public string $tempo;
    public string $titulo;
    public string $descricao;
    public string $ativo;
    public $created_at;
    public $updated_at;

    public function __construct () {}

    public function create(
        array $data
    ): Linha {
        $line = new Linha();
        $line->id = $data['id'] ?? null;
        $line->uuid = $data['uuid'] ?? $this->generateUUID();
        $line->titulo = $this->formatName($data['title']);
        $line->descricao = (string)$data['description'];
        $line->tempo = (string)$data['period'];
        $line->ativo = (int)$data['active'] ?? 1; 
        $line->created_at = $data['created_at'] ?? null;
        $line->updated_at = $data['updated_at'] ?? null;
        return $line;
    }

    public function update(array $data, Linha $line): Linha
    {
        $line->titulo = isset($data['title']) ? $this->formatName($data['title']) : $line->titulo;
        $line->descricao = $data['description'] ?? $line->descricao;
        $line->ativo = $data['active'] ?? $line->ativo;
        $line->tempo = $data['period'] ?? $line->tempo;

        return $line;
    }
}