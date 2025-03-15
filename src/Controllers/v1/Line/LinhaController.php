<?php

namespace App\Controllers\v1\Line;

use App\Controllers\Controller;
use App\Interfaces\Line\ILinhaRepository;
use App\Request\Request;
use App\Utils\Paginator;
use App\Utils\Validator;

class LinhaController extends Controller 
{
    protected $linhaRepository;

    public function __construct(ILinhaRepository $linhaRepository)
    {
        parent::__construct();  
        $this->linhaRepository = $linhaRepository;
    }

    public function index(Request $request) 
    {   
        $params = $request->getQueryParams();

        $setores = $this->linhaRepository->allLine($params);

        $perPage = 10;
        $currentPage = $request->getParam('page') ? (int)$request->getParam('page') : 1;
        $paginator = new Paginator($setores, $perPage, $currentPage);
        $paginatedBoards = $paginator->getPaginatedItems();

        return $this->router->view(
            'admin/line/index', 
            [
                'active' => 'site',
                'linhas' => $paginatedBoards,
                'links' => $paginator->links(),
                'line' => $params['line'] ?? null,
                'situation' => $params['situation'] ?? null,
                'title' => $params['title'] ?? null,
            ]
        ); 
    }

    public function create(Request $request)
    {
        return $this->router->view('admin/line/create', [
            'active' => 'cadastro',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->getBodyParams();

        $validator = new Validator($data);

        $rules = [
            'title' => 'required|min:1|max:255',
            'description' => 'required',
            'year_start' => 'required',
            'year_end' => 'required'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/line/create', [
                'active' => 'cadastro', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {         
            $data['period'] = $data['year_end'] . " - " . $data['year_start'];
            
            $create = $this->linhaRepository->create($data);

            if(is_null($create)) {
                return $this->router->view('admin/line/create', [
                    'active' => 'cadastro', 
                    'errors' => "==erros"
                ]);
            }

            return $this->router->redirect('admin/linhas');
        } catch (\Exception $e) {
            return $this->router->view('admin/line/create', [
                'active' => 'cadastro',
                'error' => 'Erro ao criar o setor: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $page = $this->linhaRepository->findByUuid($id);

        if (is_null($page)) {
            return $this->router->redirect('admin/linhas');
        }

        return $this->router->view('admin/line/edit', [
            'active' => 'cadastro',
            'page' => $page,
        ]);
    }

    public function update(Request $request, $id)
    {
        $page = $this->linhaRepository->findByUuid($id);

        if (!$page) {
            return $this->router->redirect('admin/linhas');
        }

        $data = $request->getBodyParams();

        $validator = new Validator($data);

        $rules = [
            'title' => 'required|min:1|max:255',
            'description' => 'required',
            'year_start' => 'required',
            'year_end' => 'required'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/line/create', [
                'active' => 'cadastro', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {
            
            $update = $this->linhaRepository->update($data, $page->id);

            if(is_null($update)) {
                return $this->router->view('admin/line/edit', [
                    'active' => 'cadastro', 
                    'errors' => "==erros",
                    'page' => $page
                ]);
            }

            return $this->router->redirect('admin/linhas');
        } catch (\Exception $e) {
            return $this->router->view('admin/line/edit', [
                'active' => 'cadastro',
                'error' => 'Erro ao criar o page: ' . $e->getMessage(),
                'page' => $page
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $sector = $this->linhaRepository->findByUuid($id);

        if (!$sector) {
            return $this->router->redirect('admin/linhas');
        }

        try {
            $this->linhaRepository->delete((int)$sector->id);
            return $this->router->redirect('admin/linhas');
        } catch (\Exception $e) {
            return $this->router->redirect('admin/linhas');
        }
    }

    public function active(Request $request, $id)
    {
        $colaborator = $this->linhaRepository->findByUuid($id);

        if (is_null($colaborator)) {
            return $this->router->redirect('admin/linhas');
        }

        try {
            $this->linhaRepository->active((int)$colaborator->id);
            
            return $this->router->redirect('admin/linhas');
        } catch (\Exception $e) {
            return $this->router->redirect('admin/linhas');
        }
    }
}