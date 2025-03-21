<?php

namespace App\Controllers\v1\Colaborator;

use App\Controllers\Controller;
use App\Interfaces\Colaborator\IColaboradorRepository;
use App\Interfaces\Person\IPessoaFisicaRepository;
use App\Interfaces\Sector\ISetorRepository;
use App\Interfaces\User\IUsuarioRepository;
use App\Request\Request;
use App\Utils\Paginator;
use App\Utils\Validator;

class ColaboradorController extends Controller 
{
    protected $colaboradorRepository;
    protected $setorRepository;
    protected $pessoaFisicaRepository;
    protected $usuarioRepository;

    public function __construct(
        IColaboradorRepository $colaboradorRepository,
        IPessoaFisicaRepository $pessoaFisicaRepository,
        IUsuarioRepository $usuarioRepository,
        ISetorRepository $setorRepository
    ) {
        parent::__construct();  
        $this->colaboradorRepository = $colaboradorRepository;
        $this->pessoaFisicaRepository = $pessoaFisicaRepository;
        $this->usuarioRepository = $usuarioRepository;
        $this->setorRepository = $setorRepository;
    }

    public function index(Request $request) 
    {   
        $params = $request->getQueryParams();

        $colaboradores = $this->colaboradorRepository->allColaborator($params);

        $perPage = 10;
        $currentPage = $request->getParam('page') ? (int)$request->getParam('page') : 1;
        $paginator = new Paginator($colaboradores, $perPage, $currentPage);
        $paginatedBoards = $paginator->getPaginatedItems();

        return $this->router->view(
            'admin/colaborator/index', 
            [
                'active' => 'cadastro',
                'colaboradores' => $paginatedBoards,
                'links' => $paginator->links(),
                'colaborator' => $params['colaborator'] ?? null,
                'situation' => $params['situation'] ?? null
            ]
        ); 
    }

    public function create(Request $request)
    {
        $setor = $this->setorRepository->allSector([]);

        return $this->router->view('admin/colaborator/create', [
            'active' => 'cadastro',
            'setores' => $setor
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->getBodyParams();

        $validator = new Validator($data);

        $rules = [
            'name' => 'required',
            'email' => 'required',
            'cpf' => 'required'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/colaborator/create', [
                'active' => 'cadastro', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {            
            $create = $this->colaboradorRepository->saveAll($data);

            if(is_null($create)) {
                return $this->router->view('admin/colaborator/create', [
                    'active' => 'cadastro', 
                    'errors' => "==erros"
                ]);
            }

            return $this->router->redirect('admin/colaborators');
        } catch (\Exception $e) {
            return $this->router->view('admin/colaborator/create', [
                'active' => 'cadastro',
                'error' => 'Erro ao criar o setor: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $colaborador = $this->colaboradorRepository->findByUuid($id);

        $setor = $this->setorRepository->allSector([]);

        $pessoa_fisica = $this->pessoaFisicaRepository->findById($colaborador->pessoa_fisica_id);

        if (is_null($colaborador)) {
            return $this->router->redirect('admin/colaborators');
        }

        return $this->router->view('admin/colaborator/edit', [
            'active' => 'cadastro',
            'colaborador' => $colaborador,
            'setores' => $setor,
            'pessoa_fisica' => $pessoa_fisica
        ]);
    }

    public function update(Request $request, $id)
    {
        $colaborator = $this->colaboradorRepository->findByUuid($id);

        if (is_null($colaborator)) {
            return $this->router->redirect('admin/colaborators');
        }

        $data = $request->getBodyParams();

        $validator = new Validator($data);

        $rules = [
            'name' => 'required',
            'email' => 'required',
            'cpf' => 'required'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/colaborator/create', [
                'active' => 'cadastro', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {
            $person = $this->pessoaFisicaRepository
                ->findById(
                    $colaborator
                        ->pessoa_fisica_id
                );

            $data['user_id'] = $person->usuario_id;
            $data['person_id'] = $person->id;
            $data['id'] = $colaborator->id;
            
            $update = $this->colaboradorRepository->saveAll($data);

            if(is_null($update)) {
                return $this->router->view('admin/colaborator/edit', [
                    'active' => 'cadastro', 
                    'errors' => "==erros",
                    'colaborator' => $colaborator
                ]);
            }

            return $this->router->redirect('admin/colaborators');
        } catch (\Exception $e) {
            return $this->router->view('admin/colaborator/edit', [
                'active' => 'cadastro',
                'error' => 'Erro ao criar o setor: ' . $e->getMessage(),
                'colaborator' => $colaborator
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $colaborator = $this->colaboradorRepository->findByUuid($id);

        if (is_null($colaborator)) {
            return $this->router->redirect('admin/colaborators');
        }

        try {
            $this->colaboradorRepository->delete((int)$colaborator->id);
            
            return $this->router->redirect('admin/colaborators');
        } catch (\Exception $e) {
            return $this->router->redirect('admin/colaborators');
        }
    }

    public function active(Request $request, $id)
    {
        $colaborator = $this->colaboradorRepository->findByUuid($id);

        if (is_null($colaborator)) {
            return $this->router->redirect('admin/colaborators');
        }

        try {
            $this->colaboradorRepository->active((int)$colaborator->id);
            
            return $this->router->redirect('admin/colaborators');
        } catch (\Exception $e) {
            return $this->router->redirect('admin/colaborators');
        }
    }

    public function uploadPhoto(Request $request, string $id) 
    {
        $colaborator = $this->colaboradorRepository->findByUuid($id);

        if (is_null($colaborator)) {
            return $this->router->redirect('admin/colaborators');
        }

        $person = $this->pessoaFisicaRepository
                ->findById(
                    $colaborator
                        ->pessoa_fisica_id
                );
        
        if (is_null($colaborator)) {
            return $this->router->redirect('admin/colaborators');
        }

        $data = $request->getBodyParams();

        if(isset($_FILES['file'])){
            $data['file'] = $_FILES['file'];
        }

        $dir = '/files/colaborator/';

        $file = $this->usuarioRepository
            ->updatePhoto(
                $data, 
                $dir, 
                $person->usuario_id
            );
        
        echo json_encode(
            [
                'status' => 201 , 
                'message' => 'success'
            ]
        );

        exit();
    }
}