<?php

namespace App\Repositories\Document;

use App\Config\Database;
use App\Interfaces\Document\IDocumentoRepository;
use App\Models\Document\Documento;
use App\Repositories\File\ArquivoRepository;
use App\Repositories\Traits\FindTrait;
use App\Utils\LoggerHelper;

class DocumentoRepository implements IDocumentoRepository
{
    const CLASS_NAME = Documento::class;
    const TABLE = 'documento';

    use FindTrait;
    protected $conn;
    protected $model;
    protected $arquivoRepository;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Documento();
        $this->arquivoRepository = new ArquivoRepository();
    }

    public function allDocument(array $params)
    {
        $sql = "SELECT d.*, 
                JSON_OBJECT('uuid', a.uuid, 'path', a.path ) as arquivo
            FROM " . self::TABLE . ' d
            LEFT JOIN  arquivos a on a.id =  d.arquivo_id';

        $conditions = [];
        $bindings = [];

        if (isset($params['documento'])) {
            $conditions[] = "d.nome LIKE :nome";
            $bindings[':nome'] = "%{$params['documento']}%";
        }

        if (isset($params['active'])) {
            $conditions[] = "d.ativo = :ativo";
            $bindings[':ativo'] = $params['active'];
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY d.id desc";

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
                    arquivo_id = :file_id
            ");

            $create = $stmt->execute([
                ':uuid' => $partner->uuid,
                ':name' => $partner->nome,
                ':file_id' => $partner->arquivo_id
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
                    ativo = :active
                WHERE 
                id = :id
            ");
            $update = $stmt->execute([
                ':partner' => $partner->nome,
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

    public function updateFile($file, $dir)
    {
        $file = $this->arquivoRepository->create($file, $dir);

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