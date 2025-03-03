<?php

namespace App\Controllers\v1\Page;

use App\Controllers\Controller;
use App\Interfaces\Page\IPaginaRepository;
use App\Request\Request;
use App\Utils\Paginator;
use App\Utils\Validator;

class PaginaController extends Controller 
{
    protected $paginaRepository;

    public function __construct(IPaginaRepository $paginaRepository)
    {
        parent::__construct();  
        $this->paginaRepository = $paginaRepository;
    }

    public function index(Request $request) 
    {   
        $params = $request->getQueryParams();

        $setores = $this->paginaRepository->allPages($params);

        $perPage = 10;
        $currentPage = $request->getParam('page') ? (int)$request->getParam('page') : 1;
        $paginator = new Paginator($setores, $perPage, $currentPage);
        $paginatedBoards = $paginator->getPaginatedItems();

        return $this->router->view(
            'admin/page/index', 
            [
                'active' => 'site',
                'paginas' => $paginatedBoards,
                'links' => $paginator->links(),
                'page' => $params['page'] ?? null,
                'situation' => $params['situation'] ?? null
            ]
        ); 
    }

    public function create(Request $request)
    {
        return $this->router->view('admin/page/create', [
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
            'type' => 'required'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/sector/create', [
                'active' => 'cadastro', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {         
            $create = $this->paginaRepository->create($data);

            if(is_null($create)) {
                return $this->router->view('admin/page/create', [
                    'active' => 'cadastro', 
                    'errors' => "==erros"
                ]);
            }

            return $this->router->redirect('admin/paginas');
        } catch (\Exception $e) {
            return $this->router->view('admin/page/create', [
                'active' => 'cadastro',
                'error' => 'Erro ao criar o setor: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $page = $this->paginaRepository->findByUuid($id);

        if (is_null($page)) {
            return $this->router->redirect('admin/paginas');
        }

        return $this->router->view('admin/page/edit', [
            'active' => 'cadastro',
            'page' => $page,
        ]);
    }

    public function update(Request $request, $id)
    {
        $page = $this->paginaRepository->findByUuid($id);

        if (!$page) {
            return $this->router->redirect('admin/paginas');
        }

        $data = $request->getBodyParams();

        $validator = new Validator($data);

        $rules = [
            'title' => 'required|min:1|max:255',
            'description' => 'required',
            'type' => 'required'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/page/create', [
                'active' => 'cadastro', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {
            
            $update = $this->paginaRepository->update($data, $page->id);

            if(is_null($update)) {
                return $this->router->view('admin/page/edit', [
                    'active' => 'cadastro', 
                    'errors' => "==erros",
                    'page' => $page
                ]);
            }

            return $this->router->redirect('admin/paginas');
        } catch (\Exception $e) {
            return $this->router->view('admin/page/edit', [
                'active' => 'cadastro',
                'error' => 'Erro ao criar o page: ' . $e->getMessage(),
                'page' => $page
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $sector = $this->paginaRepository->findByUuid($id);

        if (!$sector) {
            return $this->router->redirect('admin/paginas');
        }

        try {
            $this->paginaRepository->delete((int)$sector->id);
            return $this->router->redirect('setor');
        } catch (\Exception $e) {
            return $this->router->redirect('admin/paginas');
        }
    }

    public function uploadPhoto(Request $request, string $id) 
    {
        $page = $this->paginaRepository->findByUuid($id);

        $data = $request->getBodyParams();

        if(isset($_FILES['file'])){
            $data['file'] = $_FILES['file'];
        }

        $dir = '/files/page/';

        $file = $this->paginaRepository->addPhoto($data, $dir, $page->id);
        
        return $this->router->redirect('admin/paginas');
    }

    public function active(Request $request, $id)
    {
        $colaborator = $this->paginaRepository->findByUuid($id);

        if (is_null($colaborator)) {
            return $this->router->redirect('admin/paginas');
        }

        try {
            $this->paginaRepository->active((int)$colaborator->id);
            
            return $this->router->redirect('admin/paginas');
        } catch (\Exception $e) {
            return $this->router->redirect('admin/paginas');
        }
    }
}