<?php

namespace App\Controllers\v1\Dashboard;

use App\Controllers\Controller;
use App\Interfaces\Colaborator\IColaboradorRepository;
use App\Interfaces\Document\IDocumentoRepository;
use App\Interfaces\Line\ILinhaRepository;
use App\Interfaces\Partner\IParceiroRepository;
use App\Interfaces\Slide\ISlideRepository;
use App\Request\Request;

class DashboardController extends Controller 
{
    public $linhaRepository;
    protected $colaboradorRepository;
    protected $slideRepository;
    protected $parceiroRepository;
    protected $documentoRepository;

    public function __construct(
        ILinhaRepository $linhaRepository,
        IColaboradorRepository $colaboradorRepository,
        ISlideRepository $slideRepository,
        IParceiroRepository $parceiroRepository,
        IDocumentoRepository $documentoRepository
    )
    {
        parent::__construct();
        $this->linhaRepository = $linhaRepository;
        $this->colaboradorRepository = $colaboradorRepository;
        $this->slideRepository = $slideRepository;
        $this->parceiroRepository = $parceiroRepository;
        $this->documentoRepository = $documentoRepository;
    }

    public function index(Request $request)
    {
        $slides = $this->slideRepository->allSlide(['active' => 1]);
        $colaborador = $this->colaboradorRepository->allColaborator(['active' => 1]);
        $parceiros = $this->parceiroRepository->allPartner(['active' => 1]);
        $linhas = $this->linhaRepository->allLine(['active' => 1]);
        $documentos = $this->documentoRepository->allDocument(['active' => 1]);

        return $this->router->view('admin/dashboard/index', 
            [
                'active' => 'dashboard',
                'slides' => $slides,
                'colaboradores' => $colaborador,
                'parceiros' => $parceiros,
                'linhas' => $linhas,
                'documentos' => $documentos
            ]
        ); 
    }
}