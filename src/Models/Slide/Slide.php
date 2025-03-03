<?php

namespace App\Models\Slide;

use App\Controllers\v1\Traits\GenericTrait;
use App\Models\Traits\UuidTrait;

class Slide {
    
    use UuidTrait;
    use GenericTrait;

    public $id;
    public string $uuid;
    public ?string $arquivo_id;
    public $arquivo;
    public string $titulo;
    public string $descricao;
    public string $setor;
    public string $link;
    public string $ativo;
    public $created_at;
    public $updated_at;

    public function __construct () {}

    public function create(
        array $data
    ): Slide {
        $slide = new Slide();
        $slide->id = $data['id'] ?? null;
        $slide->uuid = $data['uuid'] ?? $this->generateUUID();
        $slide->titulo = $this->formatName($data['title']);
        $slide->descricao = (string)$data['description'];
        $slide->setor = (string)$data['sector'];
        $slide->link = (string)$data['link'];
        $slide->ativo = (int)$data['active'] ?? 1; 
        $slide->created_at = $data['created_at'] ?? null;
        $slide->updated_at = $data['updated_at'] ?? null;
        return $slide;
    }

    public function update(array $data, Slide $slide): Slide
    {
        $slide->titulo = isset($data['title']) ? $this->formatName($data['title']) : $slide->titulo;
        $slide->descricao = $data['description'] ?? $slide->descricao;
        $slide->ativo = $data['active'] ?? $slide->ativo;
        $slide->setor = $data['sector'] ?? $slide->setor;
        $slide->link = $data['link'] ?? $slide->link;

        return $slide;
    }
}