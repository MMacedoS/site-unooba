<?php

namespace App\Config;

use App\Interfaces\Colaborator\IColaboradorRepository;
use App\Interfaces\Document\IDocumentoRepository;
use App\Interfaces\File\IArquivoRepository;
use App\Interfaces\Line\ILinhaRepository;
use App\Interfaces\Page\IPaginaRepository;
use App\Interfaces\Partner\IParceiroRepository;
use App\Interfaces\Permission\IPermissaoRepository;
use App\Interfaces\Person\IPessoaFisicaRepository;
use App\Interfaces\Sector\ISetorRepository;
use App\Interfaces\Slide\ISlideRepository;
use App\Interfaces\User\IUsuarioRecuperarSenhaRepository;
use App\Interfaces\User\IUsuarioRepository;
use App\Repositories\Colaborator\ColaboradorRepository;
use App\Repositories\Document\DocumentoRepository;
use App\Repositories\File\ArquivoRepository;
use App\Repositories\Line\LinhaRepository;
use App\Repositories\Page\PaginaRepository;
use App\Repositories\Partner\ParceiroRepository;
use App\Repositories\Permission\PermissaoRepository;
use App\Repositories\Person\PessoaFisicaRepository;
use App\Repositories\Sector\SetorRepository;
use App\Repositories\Slide\SlideRepository;
use App\Repositories\User\UsuarioRecuperarSenhaRepository;
use App\Repositories\User\UsuarioRepository;

class AppServiceProvider 
{
    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function registerDependencies() {
        // Registra as dependências
        $this->container
            ->set(
                ISetorRepository::class, 
                new SetorRepository()
        );

        $this->container
            ->set(
                IUsuarioRepository::class, 
                new UsuarioRepository()
        );
        $this->container
            ->set(
                IUsuarioRecuperarSenhaRepository::class,
                new UsuarioRecuperarSenhaRepository()
            );

        $this->container
            ->set(
                IArquivoRepository::class,
                new ArquivoRepository()
            );

        $this->container
            ->set(
                IPessoaFisicaRepository::class,
                new PessoaFisicaRepository()
            );
                
        $this->container
            ->set(
                IPermissaoRepository::class,
                new PermissaoRepository()
            );
                
        $this->container
            ->set(
                IParceiroRepository::class,
                new ParceiroRepository()
            );
                
        $this->container
            ->set(
              IColaboradorRepository::class,
              new ColaboradorRepository()
           );                
        
        $this->container
               ->set(
                 ISlideRepository::class,
                 new SlideRepository()
              );
        
        $this->container
              ->set(
                IPaginaRepository::class,
                new PaginaRepository()
             );

        $this->container
              ->set(
                ILinhaRepository::class,
                new LinhaRepository()
             );
    
        $this->container
             ->set(
               IDocumentoRepository::class,
               new DocumentoRepository()
            );
    }
}