<?php

namespace App\Controllers\v1\Site;

use App\Controllers\Controller;
use App\Interfaces\Colaborator\IColaboradorRepository;
use App\Interfaces\Document\IDocumentoRepository;
use App\Interfaces\Line\ILinhaRepository;
use App\Interfaces\Page\IPaginaRepository;
use App\Interfaces\Partner\IParceiroRepository;
use App\Interfaces\Slide\ISlideRepository;
use App\Request\Request;

class SiteController extends Controller {
  
    public $router;
    public $linhaRepository;
    protected $colaboradorRepository;
    protected $slideRepository;
    protected $parceiroRepository;
    protected $paginaRepository;
    protected $documentoRepository;

    public function __construct(
        ILinhaRepository $linhaRepository,
        IColaboradorRepository $colaboradorRepository,
        ISlideRepository $slideRepository,
        IParceiroRepository $parceiroRepository,
        IPaginaRepository $paginaRepository,
        IDocumentoRepository $documentoRepository
    ) {
        parent::__construct();  
        $this->linhaRepository = $linhaRepository;
        $this->colaboradorRepository = $colaboradorRepository;
        $this->slideRepository = $slideRepository;
        $this->parceiroRepository = $parceiroRepository;
        $this->paginaRepository = $paginaRepository;
        $this->documentoRepository = $documentoRepository;
    }

    public function index(Request $request) 
    {
        $parceiros = $this->parceiroRepository->allPartner(['active' => 1]);
        $slides = $this->slideRepository->threeSlide(['active' => 1]);
        $paginas = $this->paginaRepository->page(['active' => 1, 'type' => 'sobre']);
        return $this->router->view(
            'site/index', 
            [
                'active' => 'principal', 
                'parceiros' => $parceiros, 
                'slides' => $slides, 
                'paginas' => $paginas
            ]
        ); 
    }

    public function about(Request $request) 
    {
        $paginas = $this->paginaRepository->page(['active' => 1, 'type' => 'sobre']);
        $documentos = $this->documentoRepository->allDocument(['active' => 1]);
        return $this->router->view(
            'site/about', 
            [
                'active' => 'sobre',
                'paginas' => $paginas,
                'documentos' => $documentos
            ]
        ); 
    }

    public function noticias(Request $request) 
    {
        return $this->router->view('site/list-news', ['active' => 'pedagogico',]); 
    }

    public function noticia(Request $request)
    {
        return $this->router->view('site/news', ['active' => 'pedagogico',]); 
    }

    public function direction() {
        $paginas = $this->paginaRepository->page(['active' => 1, 'type' => 'sobre']);
        $timeline = $this->linhaRepository->allLine([]);
        $colaboradores = $this->colaboradorRepository->allColaborator(['active' => 1]);
        return $this->router->view(
            'site/direction', 
            [
                'active' => 'diretoria', 
                'timeline' => $timeline, 
                'colaborators' => $colaboradores,
                'paginas' => $paginas
            ]
        ); 
    }
}