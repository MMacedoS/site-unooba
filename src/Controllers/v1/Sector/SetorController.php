<?php

namespace App\Controllers\v1\Sector;

use App\Controllers\Controller;
use App\Interfaces\Sector\ISetorRepository;
use App\Request\Request;
use App\Utils\Paginator;
use App\Utils\Validator;

class SetorController extends Controller 
{
    protected $setorRepository;

    public function __construct(ISetorRepository $setorRepository)
    {
        parent::__construct();  
        $this->setorRepository = $setorRepository;
    }

    public function index(Request $request) 
    {   
        $params = $request->getQueryParams();

        $setores = $this->setorRepository->allSector($params);

        $perPage = 10;
        $currentPage = $request->getParam('page') ? (int)$request->getParam('page') : 1;
        $paginator = new Paginator($setores, $perPage, $currentPage);
        $paginatedBoards = $paginator->getPaginatedItems();

        return $this->router->view(
            'admin/sector/index', 
            [
                'active' => 'cadastro',
                'setores' => $paginatedBoards,
                'links' => $paginator->links(),
                'sector' => $params['sector'] ?? null,
                'situation' => $params['situation'] ?? null
            ]
        ); 
    }

    public function create(Request $request)
    {
        return $this->router->view('admin/sector/create', [
            'active' => 'cadastro',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->getBodyParams();

        $validator = new Validator($data);

        $rules = [
            'name' => 'required|min:1|max:100',
            'order' => 'required'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/sector/create', [
                'active' => 'cadastro', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {
            
            $create = $this->setorRepository->create($data);

            if(is_null($create)) {
                return $this->router->view('admin/sector/create', [
                    'active' => 'cadastro', 
                    'errors' => "==erros"
                ]);
            }

            return $this->router->redirect('admin/sectors');
        } catch (\Exception $e) {
            return $this->router->view('admin/sector/create', [
                'active' => 'cadastro',
                'error' => 'Erro ao criar o setor: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $sector = $this->setorRepository->findByUuid($id);

        if (is_null($sector)) {
            return $this->router->redirect('admin/sectors');
        }

        return $this->router->view('admin/sector/edit', [
            'active' => 'cadastro',
            'sector' => $sector,
        ]);
    }

    public function update(Request $request, $id)
    {
        $sector = $this->setorRepository->findByUuid($id);

        if (!$sector) {
            return $this->router->redirect('admin/sectors');
        }

        $data = $request->getBodyParams();

        $validator = new Validator($data);

        $rules = [
            'name' => 'required|min:1|max:100',
            'order' => 'required'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/sector/create', [
                'active' => 'cadastro', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {
            
            $update = $this->setorRepository->update($data, $sector->id);

            if(is_null($update)) {
                return $this->router->view('admin/sector/edit', [
                    'active' => 'cadastro', 
                    'errors' => "==erros",
                    'sector' => $sector
                ]);
            }

            return $this->router->redirect('admin/sectors');
        } catch (\Exception $e) {
            return $this->router->view('admin/sector/edit', [
                'active' => 'cadastro',
                'error' => 'Erro ao criar o setor: ' . $e->getMessage(),
                'sector' => $sector
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $sector = $this->setorRepository->findByUuid($id);

        if (!$sector) {
            return $this->router->redirect('admin/sectors');
        }

        try {
            $this->setorRepository->delete((int)$sector->id);
            return $this->router->redirect('setor');
        } catch (\Exception $e) {
            return $this->router->redirect('admin/sectors');
        }
    }
}