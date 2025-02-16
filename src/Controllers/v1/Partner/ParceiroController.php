<?php

namespace App\Controllers\v1\Partner;

use App\Controllers\Controller;
use App\Interfaces\Partner\IParceiroRepository;
use App\Request\Request;
use App\Utils\Paginator;
use App\Utils\Validator;

class ParceiroController extends Controller 
{
    protected $parceiroRepository;

    public function __construct(IParceiroRepository $parceiroRepository)
    {
        parent::__construct();  
        $this->parceiroRepository = $parceiroRepository;
    }

    public function index(Request $request) 
    {   
        $params = $request->getQueryParams();

        $parceiros = $this->parceiroRepository->allPartner($params);

        $perPage = 10;
        $currentPage = $request->getParam('page') ? (int)$request->getParam('page') : 1;
        $paginator = new Paginator($parceiros, $perPage, $currentPage);
        $paginatedBoards = $paginator->getPaginatedItems();

        return $this->router->view(
            'admin/partner/index', 
            [
                'active' => 'cadastro',
                'parceiros' => $paginatedBoards,
                'links' => $paginator->links(),
                'partner' => $params['partner'] ?? null,
                'situation' => $params['situation'] ?? null
            ]
        ); 
    }

    public function create(Request $request)
    {
        return $this->router->view('admin/partner/create', [
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
            return $this->router->view('admin/partner/create', [
                'active' => 'cadastro', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {
            
            $create = $this->parceiroRepository->create($data);

            if(is_null($create)) {
                return $this->router->view('admin/partner/create', [
                    'active' => 'cadastro', 
                    'errors' => "==erros"
                ]);
            }

            return $this->router->redirect('admin/partners');
        } catch (\Exception $e) {
            return $this->router->view('admin/partner/create', [
                'active' => 'cadastro',
                'error' => 'Erro ao criar o setor: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $partner = $this->parceiroRepository->findByUuid($id);

        if (is_null($partner)) {
            return $this->router->redirect('admin/partners');
        }

        return $this->router->view('admin/partner/edit', [
            'active' => 'cadastro',
            'partner' => $partner,
        ]);
    }

    public function update(Request $request, $id)
    {
        $partner = $this->parceiroRepository->findByUuid($id);

        if (!$partner) {
            return $this->router->redirect('admin/partners');
        }

        $data = $request->getBodyParams();

        $validator = new Validator($data);

        $rules = [
            'name' => 'required|min:1|max:100',
            'description' => 'required',
            'order' => 'required'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/partner/create', [
                'active' => 'cadastro', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {
            
            $update = $this->parceiroRepository->update($data, $partner->id);

            if(is_null($update)) {
                return $this->router->view('admin/partner/edit', [
                    'active' => 'cadastro', 
                    'errors' => "==erros",
                    'partner' => $partner
                ]);
            }

            return $this->router->redirect('admin/partners');
        } catch (\Exception $e) {
            return $this->router->view('admin/partner/edit', [
                'active' => 'cadastro',
                'error' => 'Erro ao criar o setor: ' . $e->getMessage(),
                'partner' => $partner
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $partner = $this->parceiroRepository->findByUuid($id);

        if (!$partner) {
            return $this->router->redirect('admin/partners');
        }

        try {
            $this->parceiroRepository->delete((int)$partner->id);
            
            return $this->router->redirect('admin/partners');
        } catch (\Exception $e) {
            return $this->router->redirect('admin/partners');
        }
    }

    public function uploadPhoto(Request $request, string $id) 
    {
        $partner = $this->parceiroRepository->findByUuid($id);

        $data = $request->getBodyParams();

        if(isset($_FILES['file'])){
            $data['file'] = $_FILES['file'];
        }

        $dir = '/files/partner/';

        $file = $this->parceiroRepository->updatePhoto($data, $dir, $partner->id);
        
        return $this->router->redirect('admin/partners');
    }
}