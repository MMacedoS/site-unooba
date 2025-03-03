<?php

namespace App\Models\Colaborator;

use App\Models\Traits\UuidTrait;

class Colaborador {
    
    use UuidTrait;

    public $id;
    public string $uuid;
    public ?string $setor_id;
    public ?string $pessoa_fisica_id;
    public $pessoa_fisica;
    public $descricao;
    public $arquivo;
    public $graduacao;
    public $setor;
    public ?string $ativo;
    public $created_at;
    public $updated_at;

    public function __construct () {}

    public function create(
        array $data
    ): Colaborador {
        $colaborador = new Colaborador();
        $colaborador->id = isset($data['id']) ? $data['id'] : null;
        $colaborador->uuid = isset($data['uuid']) ? $data['uuid'] : $this->generateUUID();
        $colaborador->setor_id = (int)isset($data['sector_id']) ? $data['sector_id'] : null;
        $colaborador->pessoa_fisica_id = (int)isset($data['person_id']) ? $data['person_id']: null;
        $colaborador->ativo = (int)isset($data['active']) ? $data['active'] : 1; 
        $colaborador->descricao = (string)isset($data['description']) ? $data['description'] : null; 
        $colaborador->graduacao = (string)isset($data['graduation']) ? $data['graduation'] : null; 
        $colaborador->created_at = isset($data['created_at']) ? $data['created_at'] : null;
        $colaborador->updated_at = isset($data['updated_at']) ? $data['updated_at'] : null;
        return $colaborador;
    }

    public function update(array $data, Colaborador $colaborador): Colaborador
    {
        $colaborador->pessoa_fisica_id = $data['person_id'] ?? $colaborador->pessoa_fisica_id;
        $colaborador->setor_id = $data['sector_id'] ?? $colaborador->setor_id;
        $colaborador->ativo = $data['active'] ?? $colaborador->ativo;
        $colaborador->graduacao = $data['graduation'] ?? $colaborador->graduacao;
        $colaborador->descricao = $data['description'] ?? $colaborador->descricao;

        return $colaborador;
    }
}