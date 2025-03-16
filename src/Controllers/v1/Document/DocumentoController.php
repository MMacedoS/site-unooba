<?php

namespace App\Controllers\v1\Document;

use App\Controllers\Controller;
use App\Interfaces\Document\IDocumentoRepository;
use App\Interfaces\File\IArquivoRepository;
use App\Repositories\File\ArquivoRepository;
use App\Request\Request;
use App\Utils\Paginator;
use App\Utils\Validator;

class DocumentoController extends Controller 
{
    protected $documentoRepository;
    protected $arquivoRepository;

    public function __construct(IDocumentoRepository $documentoRepository, IArquivoRepository $arquivoRepository)
    {
        parent::__construct();  
        $this->documentoRepository = $documentoRepository;
        $this->arquivoRepository = $arquivoRepository;
    }

    public function index(Request $request) 
    {   
        $params = $request->getQueryParams();

        $documentos = $this->documentoRepository->allDocument($params);

        $perPage = 10;
        $currentPage = $request->getParam('page') ? (int)$request->getParam('page') : 1;
        $paginator = new Paginator($documentos, $perPage, $currentPage);
        $paginatedBoards = $paginator->getPaginatedItems();

        return $this->router->view(
            'admin/document/index', 
            [
                'active' => 'site',
                'documentos' => $paginatedBoards,
                'links' => $paginator->links(),
                'document' => $params['document'] ?? null,
                'situation' => $params['situation'] ?? null,
                'documento' => $params['documento'] ?? null
            ]
        ); 
    }

    public function create(Request $request)
    {
        return $this->router->view('admin/document/create', [
            'active' => 'site',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->getBodyParams();
        
        $validator = new Validator($data);

        $rules = [
            'name' => 'required|min:1|max:100'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/document/create', [
                'active' => 'site', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {
            if(isset($_FILES['file'])){
                $data['file'] = $_FILES['file'];
    
                $dir = '/files/documents/';

                $arquivoRepository= new ArquivoRepository();
        
                $file = $arquivoRepository->createFilePDF($_FILES['file'], $dir);

                if (is_null($file)) {
                    return $this->router->view('admin/document/create', [
                        'active' => 'site', 
                        'errors' => "==erros"
                    ]);
                }

                $data['file_id'] = $file->id;
            }
            
            $create = $this->documentoRepository->create($data);

            if(is_null($create)) {
                return $this->router->view('admin/document/create', [
                    'active' => 'site', 
                    'errors' => "==erros"
                ]);
            }

            return $this->router->redirect('admin/documentos');
        } catch (\Exception $e) {
            return $this->router->view('admin/document/create', [
                'active' => 'site',
                'error' => 'Erro ao criar o documento: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $document = (array) $this->documentoRepository->findByUuid($id);
        $document['arquivo_name'] = $this->arquivoRepository->findById((int)$document['arquivo_id']);

        if (is_null($document)) {
            return $this->router->redirect('admin/documentos');
        }

        return $this->router->view('admin/document/edit', [
            'active' => 'site',
            'documento' => $document,
        ]);
    }

    public function update(Request $request, $id)
    {
        $document = $this->documentoRepository->findByUuid($id);

        if (!$document) {
            return $this->router->redirect('admin/documents');
        }

        $data = $request->getBodyParams();

        $validator = new Validator($data);

        $rules = [
            'name' => 'required|min:1|max:100'
        ];

        if(!$validator->validate($rules)){
            return $this->router->view('admin/document/create', [
                'active' => 'site', 
                'errors' => $validator->getErrors()
            ]);
        }

        try {
            
            $update = $this->documentoRepository->update($data, $document->id);

            if(is_null($update)) {
                return $this->router->view('admin/document/edit', [
                    'active' => 'site', 
                    'errors' => "==erros",
                    'document' => $document
                ]);
            }

            return $this->router->redirect('admin/documentos');
        } catch (\Exception $e) {
            return $this->router->view('admin/document/edit', [
                'active' => 'site',
                'error' => 'Erro ao criar o document: ' . $e->getMessage(),
                'document' => $document
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $document = $this->documentoRepository->findByUuid($id);

        if (!$document) {
            return $this->router->redirect('admin/documents');
        }

        try {
            $this->documentoRepository->delete((int)$document->id);
            
            return $this->router->redirect('admin/documents');
        } catch (\Exception $e) {
            return $this->router->redirect('admin/documents');
        }
    }

    public function active(Request $request, $id)
    {
        $colaborator = $this->documentoRepository->findByUuid($id);

        if (is_null($colaborator)) {
            return $this->router->redirect('admin/documents');
        }

        try {
            $this->documentoRepository->active((int)$colaborator->id);
            
            return $this->router->redirect('admin/documents');
        } catch (\Exception $e) {
            return $this->router->redirect('admin/documents');
        }
    }
}