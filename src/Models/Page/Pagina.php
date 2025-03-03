<?php

namespace App\Models\Page;

use App\Controllers\v1\Traits\GenericTrait;
use App\Models\Traits\UuidTrait;

class Pagina {
    
    use UuidTrait;
    use GenericTrait;

    public $id;
    public string $uuid;
    public $arquivo;
    public string $titulo;
    public string $descricao;
    public string $link_video;
    public string $tipo;
    public string $ativo;
    public $created_at;
    public $updated_at;

    public function __construct () {}

    public function create(
        array $data
    ): Pagina {
        $page = new Pagina();
        $page->id = $data['id'] ?? null;
        $page->uuid = $data['uuid'] ?? $this->generateUUID();
        $page->titulo = $this->formatName($data['title']);
        $page->descricao = (string)$data['description'];
        $page->link_video = (string)$data['link_video'];
        $page->tipo = (string)$data['type'];
        $page->ativo = (int)$data['active'] ?? 1; 
        $page->created_at = $data['created_at'] ?? null;
        $page->updated_at = $data['updated_at'] ?? null;
        return $page;
    }

    public function update(array $data, Pagina $page): Pagina
    {
        $page->titulo = isset($data['title']) ? $this->formatName($data['title']) : $page->titulo;
        $page->descricao = $data['description'] ?? $page->descricao;
        $page->ativo = $data['active'] ?? $page->ativo;
        $page->link_video = $data['link_video'] ?? $page->link_video;
        $page->tipo = $data['type'] ?? $page->tipo;

        return $page;
    }
}