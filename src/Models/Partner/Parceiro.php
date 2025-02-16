<?php

namespace App\Models\Partner;

use App\Controllers\v1\Traits\GenericTrait;
use App\Models\File\Arquivo;
use App\Models\Traits\UuidTrait;

class Parceiro {
    
    use UuidTrait;
    use GenericTrait;

    public $id;
    public string $uuid;
    public string $nome;
    public string $ativo;
    public string $ordem;
    public ?string $descricao;
    public ?string $arquivo_id;
    public $arquivo;
    public $created_at;
    public $updated_at;

    public function __construct () {}

    public function create(
        array $data
    ): Parceiro {
        $partner = new Parceiro();
        $partner->id = $data['id'] ?? null;
        $partner->uuid = $data['uuid'] ?? $this->generateUUID();
        $partner->nome = $this->formatName($data['name']);
        $partner->ordem = (string)$data['order'];
        $partner->descricao = (string)$data['description'];
        $partner->arquivo_id = $data['file_id'] ?? null;
        $partner->ativo = (int)$data['active'] ?? 1; 
        $partner->created_at = $data['created_at'] ?? null;
        $partner->updated_at = $data['updated_at'] ?? null;
        return $partner;
    }

    public function update(array $data, Parceiro $partner): Parceiro
    {
        $partner->nome = isset($data['name']) ? $this->formatName($data['name']) : $partner->nome;
        $partner->ordem = $data['order'] ?? $partner->ordem;
        $partner->descricao = $data['description'] ?? $partner->descricao;
        $partner->arquivo_id = $data['file_id'] ?? $partner->arquivo_id;
        $partner->ativo = $data['active'] ?? $partner->ativo;

        return $partner;
    }
}