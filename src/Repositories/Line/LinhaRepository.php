<?php

namespace App\Repositories\Line;

use App\Config\Database;
use App\Interfaces\Line\ILinhaRepository;
use App\Models\Line\Linha;
use App\Repositories\Traits\FindTrait;
use App\Utils\LoggerHelper;

class LinhaRepository implements ILinhaRepository
{
    const CLASS_NAME = Linha::class;
    const TABLE = 'linha_tempo';

    use FindTrait;
    protected $conn;
    protected $model;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Linha();
    }

    public function allLine(array $params)
    {
        $sql = "SELECT *
            FROM " . self::TABLE;
    
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
    
        $sql .= " ORDER BY tempo ASC";
    
        $stmt = $this->conn->prepare($sql);
    
        $stmt->execute($bindings);
    
        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);  
    }

    public function create(array $params)
    {
        $existingSlide = $this->findByTitle($params['period']);
        
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
                    tempo = :tempo
            ");
            $create = $stmt->execute([
                ':uuid' => $slide->uuid,
                ':title' => $slide->titulo,
                ':description' => $slide->descricao,
                ':tempo' => $slide->tempo
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
                    tempo = :tempo
                WHERE 
                id = :id
            ");
            $update = $stmt->execute([
                ':title' => $slide->titulo,
                ':description' => $slide->descricao,
                ':tempo' => $slide->tempo,
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

    private function findByTitle(string $tempo)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM " . self::TABLE . " WHERE tempo = :tempo LIMIT 1"
            );
            $stmt->execute([':tempo' => $tempo]);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, self::CLASS_NAME);

            return $stmt->fetch() ?: null;
        } catch (\Throwable $th) {
            LoggerHelper::logInfo($th->getMessage());
            return null;
        } finally {          
            Database::getInstance()->closeConnection();
        }
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