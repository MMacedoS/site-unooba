<?php

namespace App\Repositories\Colaborator;

use App\Config\Database;
use App\Interfaces\Colaborator\IColaboradorRepository;
use App\Models\Colaborator\Colaborador;
use App\Repositories\File\ArquivoRepository;
use App\Repositories\Person\PessoaFisicaRepository;
use App\Repositories\Traits\FindTrait;
use App\Repositories\User\UsuarioRepository;
use App\Utils\LoggerHelper;

class ColaboradorRepository implements IColaboradorRepository
{
    const CLASS_NAME = Colaborador::class;
    const TABLE = 'colaborador';

    use FindTrait;
    protected $conn;
    protected $model;
    protected $pessoaFisicaRepository;
    protected $usuarioRepository;
    protected $arquivoRepository;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Colaborador();
        $this->pessoaFisicaRepository = new PessoaFisicaRepository();
        $this->usuarioRepository = new UsuarioRepository();
        $this->arquivoRepository = new ArquivoRepository();
    }

    public function allColaborator(array $params)
    {
        $sql = "SELECT c.*, 
                JSON_OBJECT('uuid', a.uuid, 'path', a.path ) as arquivo,
                JSON_OBJECT('uuid', pf.uuid, 'nome', pf.nome,'email', pf.email ) as pessoa_fisica,
                JSON_OBJECT('uuid', s.uuid, 'nome', s.nome,'ordem', s.ordem ) as setor
            FROM " . self::TABLE . ' c
            LEFT JOIN pessoa_fisica pf on pf.id =  c.pessoa_fisica_id 
            LEFT JOIN usuarios u on u.id = pf.usuario_id 
            LEFT JOIN arquivos a on a.id =  u.arquivo_id             
            LEFT JOIN setor s on s.id = c.setor_id ';

        $conditions = [];
        $bindings = [];
      
        if (isset($params['colaborator'])) {
            $conditions[] = "pf.nome LIKE :nome";
            $bindings[':nome'] = "%{$params['colaborator']}%";
        }

        if (isset($params['active'])) {
            $conditions[] = "c.ativo = :ativo";
            $bindings[':ativo'] = $params['active'];
        }

        if (isset($params['situation']) && $params['situation'] != '') {
            $conditions[] = "c.ativo = :ativo";
            $bindings[':ativo'] = $params['situation'];
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY s.ordem ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);  
        
    }

    public function saveAll(array $params) 
    {
        if(is_null($params) || empty($params)) {
            return null;
        }

        $this->conn->beginTransaction();

        try {

            if(isset($params['user_id'])) {
                $params['acesso'] = 'comunicacao'; 
                $params['password'] = 'unooba123'; 
                $user = $this->usuarioRepository->update($params, $params['user_id']);
    
                if (is_null($user)) {
                    $this->conn->rollBack();
                    return null;
                }
            }

            if (!isset($params['user_id'])) {
                $params['acesso'] = 'comunicacao'; 
                $user = $this->usuarioRepository->create($params);
    
                if (is_null($user)) {
                    $this->conn->rollBack();
                    return null;
                }
            }
            
            $params['user_id'] = $user->id; 

            if (isset($params['person_id'])) {
                $person = $this->pessoaFisicaRepository
                    ->update(
                        $params, 
                        $params['person_id']
                    );
    
                if (is_null($person)) {
                    $this->conn->rollBack();
                    return null;
                }
            }

            if (!isset($params['person_id'])) {
                $person = $this->pessoaFisicaRepository
                    ->create($params);

                if (is_null($person)) {
                    $this->conn->rollBack();
                    return null;
                }
            }

            $params['person_id'] = $person->id;
            
            if (isset($params['id'])) {
                $colaborator = $this->update(
                    $params, 
                    $params['id']
                );
    
                if (is_null($colaborator)) {
                    $this->conn->rollBack();
                    return null;
                }
            }
  
            if (!isset($params['id'])) {
                $colaborator = $this->create($params);

                if (is_null($colaborator)) {
                    $this->conn->rollBack();
                    return null;
                }
            }

            $this->conn->commit();
            return $colaborator;
            
        } catch (\Throwable $th) {
            $this->conn->rollBack();
            return null;
        }
    }

    public function create(array $params)
    {
        $existingColaborator = $this->findByColaborator($params);
        
        if (!is_null($existingColaborator)) {
            return $existingColaborator;
        }

        try {
            $colaborator = $this->model->create(
                $params
            );

            $stmt = $this->conn
            ->prepare(
                "INSERT INTO " . self::TABLE . " 
                  set 
                    uuid = :uuid,
                    setor_id = :setor_id,
                    pessoa_fisica_id = :pessoa_fisica_id,
                    graduacao = :graduacao,
                    descricao = :description
            ");
            $create = $stmt->execute([
                ':uuid' => $colaborator->uuid,
                ':setor_id' => (int)$colaborator->setor_id,
                ':pessoa_fisica_id' => (int)$colaborator->pessoa_fisica_id,
                ':graduacao' => $colaborator->graduacao,
                ':description' => $colaborator->descricao
            ]);
    
            if (is_null($create)) {
                return null;
            }

            $created = $this->findByUuid($colaborator->uuid);
           
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
        $colaborator = $this->findById((int)$id);
        
        if (is_null($colaborator)) {
            return null;
        }

        $colaborator = $this->model->update(
            $params,
            $colaborator
        );

        try {
            $stmt = $this->conn
            ->prepare(
                "UPDATE " . self::TABLE . " 
                  set 
                    setor_id = :setor_id,
                    pessoa_fisica_id = :pessoa_fisica_id, 
                    graduacao = :graduacao,
                    descricao = :description
                WHERE id = :id 
            ");
            $update = $stmt->execute([
                ':setor_id' => $colaborator->setor_id,
                ':pessoa_fisica_id' => $colaborator->pessoa_fisica_id,
                ':graduacao' => $colaborator->graduacao,
                ':description' => $colaborator->descricao,
                ':id' => (int)$id
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

    private function findByColaborator(array $colaborator)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM " . self::TABLE . " WHERE setor_id = :setor_id and pessoa_fisica_id = :pessoa_fisica_id LIMIT 1"
            );
            $stmt->execute(
                [
                ':setor_id' => $colaborator['sector_id'], 
                ':pessoa_fisica_id' => $colaborator['person_id']
                ]
            );
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