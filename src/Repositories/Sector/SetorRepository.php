<?php

namespace App\Repositories\Sector;

use App\Config\Database;
use App\Interfaces\Sector\ISetorRepository;
use App\Models\Sector\Setor;
use App\Repositories\Traits\FindTrait;
use App\Utils\LoggerHelper;

class SetorRepository implements ISetorRepository 
{
    const CLASS_NAME = Setor::class;
    const TABLE = 'setor';

    use FindTrait;
    protected $conn;
    protected $model;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Setor();
    }

    public function allSector(array $params)
    {
        $sql = "SELECT * FROM " . self::TABLE;

        $conditions = [];
        $bindings = [];

        if (isset($params['sector'])) {
            $conditions[] = "nome LIKE :setor";
            $bindings[':setor'] = "%{$params['sector']}%";
        }

        if (isset($params['active'])) {
            $conditions[] = "ativo = :ativo";
            $bindings[':ativo'] = $params['active'];
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY ordem ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);  
        
    }

    public function create(array $params)
    {
        $existingSector = $this->findBySector($params['name']);
        
        if ($existingSector) {
            return $existingSector;
        }

        $sector = $this->model->create(
            $params
        );

        try {
            $stmt = $this->conn
            ->prepare(
                "INSERT INTO " . self::TABLE . " 
                  set 
                    uuid = :uuid,
                    nome = :sector,
                    ordem = :order
            ");
            $create = $stmt->execute([
                ':uuid' => $sector->uuid,
                ':sector' => $sector->nome,
                ':order' => $sector->ordem
            ]);
    
            if (is_null($create)) {
                return null;
            }

            $created = $this->findByUuid($sector->uuid);
           
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

        $sector = $this->model->update(
            $params,
            $sector
        );

        try {
            $stmt = $this->conn
            ->prepare(
                "UPDATE " . self::TABLE . " 
                  set 
                    nome = :sector,
                    ordem = :order,
                    ativo = :active
                WHERE 
                id = :id
            ");
            $update = $stmt->execute([
                ':sector' => $sector->nome,
                ':order' => $sector->ordem,
                ':active' => $sector->ativo,
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

    private function findBySector(string $sector)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM " . self::TABLE . " WHERE nome= :sector LIMIT 1"
            );
            $stmt->execute([':sector' => $sector]);
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