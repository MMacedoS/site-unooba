<?php

namespace App\Repositories\Slide;

use App\Config\Database;
use App\Interfaces\Slide\ISlideRepository;
use App\Models\Slide\Slide;
use App\Repositories\File\ArquivoRepository;
use App\Repositories\Traits\FindTrait;
use App\Utils\LoggerHelper;

class SlideRepository implements ISlideRepository 
{
    const CLASS_NAME = Slide::class;
    const TABLE = 'slide';

    use FindTrait;
    protected $conn;
    protected $model;
    protected $arquivoRepository;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Slide();
        $this->arquivoRepository = new ArquivoRepository();
    }

    public function allSlide(array $params)
    {
        $sql = "SELECT s.*, 
                JSON_OBJECT('uuid', a.uuid, 'path', a.path ) as arquivo
            FROM " . self::TABLE . ' s
            LEFT JOIN  arquivos a on a.id =  s.arquivo_id';

        $conditions = [];
        $bindings = [];
        
        if (isset($params['title'])) {
            $conditions[] = "titulo LIKE :title";
            $bindings[':title'] = "%{$params['title']}%";
        }

        if (isset($params['active'])) {
            $conditions[] = "p.ativo = :ativo";
            $bindings[':ativo'] = $params['active'];
        }

        if (isset($params['situation']) && $params['situation'] != '') {
            $conditions[] = "ativo = :ativo";
            $bindings[':ativo'] = $params['situation'];
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY titulo ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);  
        
    }

    public function threeSlide(array $params)
    {
        $sql = "SELECT s.*, 
                JSON_OBJECT('uuid', a.uuid, 'path', a.path ) as arquivo
            FROM " . self::TABLE . ' s
            LEFT JOIN  arquivos a on a.id =  s.arquivo_id';

        $conditions = [];
        $bindings = [];

        if (isset($params['title'])) {
            $conditions[] = "titulo = :title";
            $bindings[':title'] = $params['title'];
        }

        if (isset($params['active'])) {
            $conditions[] = "ativo = :ativo";
            $bindings[':ativo'] = $params['active'];
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY titulo ASC limit 3";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);  
        
    }

    public function create(array $params)
    {
        $existingSlide = $this->findByTitle($params['title']);
        
        if ($existingSlide) {
            return $existingSlide;
        }

        $slide = $this->model->create(
            $params
        );

        try {
            $stmt = $this->conn
            ->prepare(
                "INSERT INTO " . self::TABLE . " 
                  set 
                    uuid = :uuid,
                    titulo = :title,
                    descricao = :description,
                    setor = :sector,
                    link = :link
            ");
            $create = $stmt->execute([
                ':uuid' => $slide->uuid,
                ':sector' => $slide->setor,
                ':title' => $slide->titulo,
                ':description' => $slide->descricao,
                ':link' => $slide->link
            ]);
    
            if (is_null($create)) {
                return null;
            }

            $created = $this->findByUuid($slide->uuid);
           
            return $created;
        } catch (\Throwable $th) {
            LoggerHelper::logInfo($th->getMessage());
            return null;
        } finally {          
            Database::getInstance()->closeConnection();
        }        
    }

    public function update(array $params, int $id)
    {
        $sector = $this->findById((int)$id);
        
        if (is_null($sector)) {
            return null;
        }

        $slide = $this->model->update(
            $params,
            $sector
        );

        try {
            $stmt = $this->conn
            ->prepare(
                "UPDATE " . self::TABLE . " 
                  set 
                    titulo = :title,
                    descricao = :description,
                    setor = :sector,
                    link = :link
                WHERE 
                id = :id
            ");
            $update = $stmt->execute([
                ':sector' => $slide->setor,
                ':title' => $slide->titulo,
                ':description' => $slide->descricao,
                ':link' => $slide->link,
                ':id' => $id
            ]);
    
            if (is_null($update)) {
                return null;
            }

            $updated = $this->findById($id);
           
            return $updated;
        } catch (\Throwable $th) {
            LoggerHelper::logInfo($th->getMessage());
            return null;
        } finally {          
            Database::getInstance()->closeConnection();
        }
    }

    public function delete(int $id)
    {
        $stmt = $this->conn
        ->prepare(
            "UPDATE " . self::TABLE . " 
             SET ativo = 0 
             WHERE id = :id"
        );

        $updated = $stmt->execute([':id' => $id]);

        return $updated;
    }

    private function findByTitle(string $title)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM " . self::TABLE . " WHERE titulo = :title LIMIT 1"
            );
            $stmt->execute([':title' => $title]);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::CLASS_NAME);

            return $stmt->fetch() ?: null;
        } catch (\Throwable $th) {
            LoggerHelper::logInfo($th->getMessage());
            return null;
        } finally {          
            Database::getInstance()->closeConnection();
        }
    }

    public function updatePhoto($file, $dir, $id)
    {
        $file = $this->arquivoRepository->create($file, $dir);

        $stmt = $this->conn
        ->prepare(
            "UPDATE " . self::TABLE . " 
             SET arquivo_id = :file_id 
             WHERE id = :id"
        );

        $updated = $stmt->execute([':id' => $id, ':file_id' => $file->id]);

        return $file;
    }

    public function active(int $id)
    {
        $stmt = $this->conn
        ->prepare(
            "UPDATE " . self::TABLE . " 
             SET ativo = 1 
             WHERE id = :id"
        );

        $updated = $stmt->execute([':id' => $id]);

        return $updated;
    }
}