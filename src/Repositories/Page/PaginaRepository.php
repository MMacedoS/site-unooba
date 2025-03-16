<?php

namespace App\Repositories\Page;

use App\Config\Database;
use App\Interfaces\Page\IPaginaRepository;
use App\Models\Page\Page;
use App\Models\Page\Pagina;
use App\Repositories\File\ArquivoRepository;
use App\Repositories\Traits\FindTrait;
use App\Utils\LoggerHelper;

class PaginaRepository implements IPaginaRepository
{
    const CLASS_NAME = Pagina::class;
    const TABLE = 'pagina';

    use FindTrait;
    protected $conn;
    protected $model;
    protected $arquivoRepository;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Pagina();
        $this->arquivoRepository = new ArquivoRepository();
    }

    public function allPages(array $params)
    {
        $sql = "SELECT p.*, 
                JSON_OBJECT('uuid', a.uuid, 'path', a.path ) as arquivo
            FROM " . self::TABLE . ' p
            LEFT JOIN pagina_has_arquivo pha ON pha.pagina_id = p.id
            LEFT JOIN arquivos a ON a.id = pha.arquivo_id';
    
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
    
        $sql .= " ORDER BY p.titulo ASC";
    
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
                    tipo = :tipo,
                    link_video = :link
            ");
            $create = $stmt->execute([
                ':uuid' => $slide->uuid,
                ':title' => $slide->titulo,
                ':description' => $slide->descricao,
                ':tipo' => $slide->tipo,
                ':link' => $slide->link_video
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
                    tipo = :tipo,
                    link_video = :link
                WHERE 
                id = :id
            ");
            $update = $stmt->execute([
                ':title' => $slide->titulo,
                ':description' => $slide->descricao,
                ':tipo' => $slide->tipo,
                ':link' => $slide->link_video,
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

    public function addPhoto($file, $dir, $id)
    {
        $file = $this->arquivoRepository->create($file, $dir);
    
        $stmtUpdate = $this->conn->prepare(
            "UPDATE pagina_has_arquivo  
             SET arquivo_id = :file_id 
             WHERE pagina_id = :id"
        );
        $stmtUpdate->execute([':id' => $id, ':file_id' => $file->id]);
    
        if ($stmtUpdate->rowCount() === 0) {
            $stmtInsert = $this->conn->prepare(
                "INSERT INTO pagina_has_arquivo  
                 SET arquivo_id = :file_id, 
                 pagina_id = :id"
            );
            $stmtInsert->execute([':id' => $id, ':file_id' => $file->id]);
        }
    
        $stmtGetOldFile = $this->conn->prepare(
            "SELECT arquivo_id FROM pagina_has_arquivo WHERE pagina_id = :id"
        );
        $stmtGetOldFile->execute([':id' => $id]);
        $oldFileId = $stmtGetOldFile->fetchColumn();
    
        if ($oldFileId && $oldFileId != $file->id) {
            $oldFile = $this->arquivoRepository->findById($oldFileId);
            if ($oldFile && file_exists($dir . '/' . $oldFile->path)) {
                unlink($dir . '/' . $oldFile->path);
            }
            $this->arquivoRepository->delete($oldFileId);
        }
    
        return $file;
    }

    public function page(array $params)
    {
        $sql = "SELECT p.*, 
                JSON_OBJECT('uuid', a.uuid, 'path', a.path ) as arquivo
            FROM " . self::TABLE . ' p
            LEFT JOIN pagina_has_arquivo pha ON pha.pagina_id = p.id
            LEFT JOIN arquivos a ON a.id = pha.arquivo_id';
    
        $conditions = [];
        $bindings = [];
    
        if (isset($params['title'])) {
            $conditions[] = "p.titulo = :title";
            $bindings[':title'] = $params['title'];
        }
    
        if (isset($params['active'])) {
            $conditions[] = "p.ativo = :ativo";
            $bindings[':ativo'] = $params['active'];
        }
    
        if (isset($params['type'])) {
            $conditions[] = "p.tipo = :tipo";
            $bindings[':tipo'] = $params['type'];
        }
    
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
    
        $sql .= " ORDER BY p.titulo ASC";
    
        $stmt = $this->conn->prepare($sql);
    
        $stmt->execute($bindings);
    
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::CLASS_NAME);

        return $stmt->fetch() ?: null;
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