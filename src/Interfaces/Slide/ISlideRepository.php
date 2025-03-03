<?php

namespace App\Interfaces\Slide;

interface ISlideRepository 
{
    public function allSlide(array $params);

    public function create(array $params);
    
    public function update(array $params, int $id);

    public function findByUuid(string $uuid);

    public function findById(int $id);

    public function delete(int $id);

    public function updatePhoto($file, $dir, $id_user);

    public function threeSlide(array $params);

    public function active(int $id);
}