<?php

namespace App\Config;

use App\Controllers\v1\Sector\SetorController;
use App\Interfaces\File\IArquivoRepository;
use App\Interfaces\Partner\IParceiroRepository;
use App\Interfaces\Permission\IPermissaoRepository;
use App\Interfaces\Person\IPessoaFisicaRepository;
use App\Interfaces\Sector\ISetorRepository;
use App\Interfaces\User\IUsuarioRecuperarSenhaRepository;
use App\Interfaces\User\IUsuarioRepository;
use App\Repositories\File\ArquivoRepository;
use App\Repositories\Partner\ParceiroRepository;
use App\Repositories\Permission\PermissaoRepository;
use App\Repositories\Person\PessoaFisicaRepository;
use App\Repositories\Sector\SetorRepository;
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
    }
}