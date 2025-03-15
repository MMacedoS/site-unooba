<?php

namespace App\Controllers\v1\Slide;

use App\Controllers\Controller;
use App\Interfaces\Slide\ISlideRepository;
use App\Request\Request;
use App\Utils\Paginator;
use App\Utils\Validator;

class SlideController extends Controller 
{
    protected $slideRepository;

    public function __construct(ISlideRepository $slideRepository)
    {
        parent::__construct();  
        $this->slideRepository = $slideRepository;
    }

    public function index(Request $request) 
    {   
        $params = $request->getQueryParams();

        $setores = $this->slideRepository->allSlide($params);

        $perPage = 10;
        $currentPage = $request->getParam('page') ? (int)$request->getParam('page') : 1;
        $paginator = new Paginator($setores, $perPage, $currentPage);
        $paginatedBoards = $paginator->getPaginatedItems();

        return $this->router->view(
            'admin/slide/index', 
            [
                'active' => 'site',
                'slides' => $paginatedBoards,
                'links' => $paginator->links(),
                'slide' => $params['slide'] ?? null,
                'situation' => $params['situation'] ?? null,
                'title' => $params['title'] ?? null
            ]
        ); 
    }

    public function create(Request $request)
    {
        return $this->router->view('admin/slide/create', [
            'active' => 'cadastro',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->getBodyParams();

        $validator = new Validator($data);

        $rules = [
            'title' => 'required|min:1|max:255',
            'description' => 'required'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/sector/create', [
                'active' => 'cadastro', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {         
            $create = $this->slideRepository->create($data);

            if(is_null($create)) {
                return $this->router->view('admin/slide/create', [
                    'active' => 'cadastro', 
                    'errors' => "==erros"
                ]);
            }

            return $this->router->redirect('admin/slides');
        } catch (\Exception $e) {
            return $this->router->view('admin/slide/create', [
                'active' => 'cadastro',
                'error' => 'Erro ao criar o setor: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $slide = $this->slideRepository->findByUuid($id);

        if (is_null($slide)) {
            return $this->router->redirect('admin/slides');
        }

        return $this->router->view('admin/slide/edit', [
            'active' => 'cadastro',
            'slide' => $slide,
        ]);
    }

    public function update(Request $request, $id)
    {
        $slide = $this->slideRepository->findByUuid($id);

        if (!$slide) {
            return $this->router->redirect('admin/slides');
        }

        $data = $request->getBodyParams();

        $validator = new Validator($data);

        $rules = [
            'title' => 'required|min:1|max:255',
            'description' => 'required'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/slide/create', [
                'active' => 'cadastro', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {
            
            $update = $this->slideRepository->update($data, $slide->id);

            if(is_null($update)) {
                return $this->router->view('admin/slide/edit', [
                    'active' => 'cadastro', 
                    'errors' => "==erros",
                    'slide' => $slide
                ]);
            }

            return $this->router->redirect('admin/slides');
        } catch (\Exception $e) {
            return $this->router->view('admin/slide/edit', [
                'active' => 'cadastro',
                'error' => 'Erro ao criar o slide: ' . $e->getMessage(),
                'slide' => $slide
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $sector = $this->slideRepository->findByUuid($id);

        if (!$sector) {
            return $this->router->redirect('admin/slides');
        }

        try {
            $this->slideRepository->delete((int)$sector->id);
            return $this->router->redirect('setor');
        } catch (\Exception $e) {
            return $this->router->redirect('admin/slides');
        }
    }

    public function uploadPhoto(Request $request, string $id) 
    {
        $slide = $this->slideRepository->findByUuid($id);

        $data = $request->getBodyParams();

        if(isset($_FILES['file'])){
            $data['file'] = $_FILES['file'];
        }

        $dir = '/files/slide/';

        $file = $this->slideRepository->updatePhoto($data, $dir, $slide->id);
        
        return $this->router->redirect('admin/slides');
    }

    public function active(Request $request, $id)
    {
        $colaborator = $this->slideRepository->findByUuid($id);

        if (is_null($colaborator)) {
            return $this->router->redirect('admin/slides');
        }

        try {
            $this->slideRepository->active((int)$colaborator->id);
            
            return $this->router->redirect('admin/slides');
        } catch (\Exception $e) {
            return $this->router->redirect('admin/slides');
        }
    }
}