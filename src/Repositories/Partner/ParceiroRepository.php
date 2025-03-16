<?php

namespace App\Repositories\Partner;

use App\Config\Database;
use App\Interfaces\Partner\IParceiroRepository;
use App\Models\Partner\Parceiro;
use App\Repositories\File\ArquivoRepository;
use App\Repositories\Traits\FindTrait;
use App\Utils\LoggerHelper;

class ParceiroRepository implements IParceiroRepository
{
    const CLASS_NAME = Parceiro::class;
    const TABLE = 'parceiro';

    use FindTrait;
    protected $conn;
    protected $model;
    protected $arquivoRepository;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Parceiro();
        $this->arquivoRepository = new ArquivoRepository();
    }

    public function allPartner(array $params)
    {
        $sql = "SELECT p.*, 
                JSON_OBJECT('uuid', a.uuid, 'path', a.path ) as arquivo
            FROM " . self::TABLE . ' p
            LEFT JOIN  arquivos a on a.id =  p.arquivo_id';

        $conditions = [];
        $bindings = [];

        if (isset($params['partner'])) {
            $conditions[] = "nome LIKE :nome";
            $bindings[':nome'] = "%{$params['partner']}%";
        }

        if (isset($params['active'])) {
            $conditions[] = "p.ativo = :ativo";
            $bindings[':ativo'] = $params['active'];
        }

        if (isset($params['situation']) && $params['situation'] != '') {
            $conditions[] = "p.ativo = :ativo";
            $bindings[':ativo'] = $params['situation'];
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
        $existingPartner = $this->findByPartner($params['name']);
        
        if ($existingPartner) {
            return $existingPartner;
        }

        $partner = $this->model->create(
            $params
        );

        try {
            $stmt = $this->conn
            ->prepare(
                "INSERT INTO " . self::TABLE . " 
                  set 
                    uuid = :uuid,
                    nome = :name,
                    ordem = :order,
                    descricao = :description
            ");
            $create = $stmt->execute([
                ':uuid' => $partner->uuid,
                ':name' => $partner->nome,
                ':order' => $partner->ordem,
                ':description' => $partner->descricao
            ]);
    
            if (is_null($create)) {
                return null;
            }

            $created = $this->findByUuid($partner->uuid);
           
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
        $partner = $this->findById((int)$id);
        
        if (is_null($partner)) {
            return null;
        }

        $partner = $this->model->update(
            $params,
            $partner
        );

        try {
            $stmt = $this->conn
            ->prepare(
                "UPDATE " . self::TABLE . " 
                  set 
                    nome = :partner,                    
                    ordem = :order,
                    descricao = :description,
                    ativo = :active
                WHERE 
                id = :id
            ");
            $update = $stmt->execute([
                ':partner' => $partner->nome,
                ':order' => $partner->ordem,
                ':description' => $partner->descricao,
                ':active' => $partner->ativo,
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

    private function findByPartner(string $partner)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM " . self::TABLE . " WHERE nome= :partner LIMIT 1"
            );
            $stmt->execute([':partner' => $partner]);
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