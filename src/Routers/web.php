<?php

use App\Config\AppServiceProvider;
use App\Config\Auth;
use App\Config\Container;
use App\Config\Router;
use App\Controllers\v1\Colaborator\ColaboradorController;
use App\Controllers\v1\Dashboard\DashboardController;
use App\Controllers\v1\Document\DocumentoController;
use App\Controllers\v1\Line\LinhaController;
use App\Controllers\v1\NotFound\NotFoundController;
use App\Controllers\v1\Page\PaginaController;
use App\Controllers\v1\Partner\ParceiroController;
use App\Controllers\v1\Sector\SetorController;
use App\Controllers\v1\Site\SiteController;
use App\Controllers\v1\Slide\SlideController;
use App\Controllers\v1\User\UsuarioController;

$container = new Container();
$appServiceProvider = new AppServiceProvider($container);
$appServiceProvider->registerDependencies();

$siteController = $container->get(SiteController::class);
$dashboardController = $container->get(DashboardController::class);
$usuarioController = $container->get(UsuarioController::class);
$setorController = $container->get(SetorController::class);
$partnerController = $container->get(ParceiroController::class);
$colaboratorController = $container->get(ColaboradorController::class);
$slideController = $container->get(SlideController::class);
$paginaController = $container->get(PaginaController::class);
$linhaController = $container->get(LinhaController::class);
$documentoController = $container->get(DocumentoController::class);


$router = new Router();
$auth = new Auth();

$notFoundController = new NotFoundController();

///site
$router->create("GET", "/", [$siteController, "index"], null);

$router->create("GET", "/sobre", [$siteController, "about"], null);

$router->create("GET", "/diretoria", [$siteController, "direction"], null);

// $router->create("GET", "/noticias", [$siteController, "noticias"], null);

// $router->create("GET", "/noticias/{title}", [$siteController, "noticia"], null);

$router->create('GET', '/not-found', [$notFoundController, 'index']);

////login
$router->create('GET', "/login", [$usuarioController, 'login'], null);

$router->create('POST', "/login", [$usuarioController, 'auth'], null);

///// dashboard
$router->create('GET', "/dashboard", [$dashboardController, 'index'], $auth);

////setores
$router->create('GET', '/admin/sectors', [$setorController, 'index'], $auth);

$router->create('GET', '/admin/sector', [$setorController, 'create'], $auth);

$router->create('POST', '/admin/sector', [$setorController, 'store'], $auth);

$router->create('GET', '/admin/sector/{id}', [$setorController, 'edit'], $auth);

$router->create('POST', '/admin/sector/{id}', [$setorController, 'update'], $auth);

$router->create('DELETE', '/admin/sector/{id}', [$setorController, 'destroy'], $auth);

$router->create('GET', '/admin/sector/{id}/active', [$setorController, 'active'], $auth);

////parceiros
$router->create('GET', '/admin/partners', [$partnerController, 'index'], $auth);

$router->create('GET', '/admin/partner', [$partnerController, 'create'], $auth);

$router->create('POST', '/admin/partner', [$partnerController, 'store'], $auth);

$router->create('GET', '/admin/partner/{id}', [$partnerController, 'edit'], $auth);

$router->create('POST', '/admin/partner/{id}', [$partnerController, 'update'], $auth);

$router->create('DELETE', '/admin/partner/{id}', [$partnerController, 'destroy'], $auth);

$router->create('POST', '/admin/partner/{id}/upload', [$partnerController, 'uploadPhoto'], $auth);

$router->create('GET', '/admin/partner/{id}/active', [$partnerController, 'active'], $auth);

////colaborator
$router->create('GET', '/admin/colaborators', [$colaboratorController, 'index'], $auth);

$router->create('GET', '/admin/colaborator', [$colaboratorController, 'create'], $auth);

$router->create('POST', '/admin/colaborator', [$colaboratorController, 'store'], $auth);

$router->create('GET', '/admin/colaborator/{id}', [$colaboratorController, 'edit'], $auth);

$router->create('POST', '/admin/colaborator/{id}', [$colaboratorController, 'update'], $auth);

$router->create('DELETE', '/admin/colaborator/{id}', [$colaboratorController, 'destroy'], $auth);

$router->create('POST', '/admin/colaborator/{id}/upload', [$colaboratorController, 'uploadPhoto'], $auth);

$router->create('GET', '/admin/colaborator/{id}/active', [$colaboratorController, 'active'], $auth);

////slides
$router->create('GET', '/admin/slides', [$slideController, 'index'], $auth);

$router->create('GET', '/admin/slide', [$slideController, 'create'], $auth);

$router->create('POST', '/admin/slide', [$slideController, 'store'], $auth);

$router->create('GET', '/admin/slide/{id}', [$slideController, 'edit'], $auth);

$router->create('POST', '/admin/slide/{id}', [$slideController, 'update'], $auth);

$router->create('DELETE', '/admin/slide/{id}', [$slideController, 'destroy'], $auth);

$router->create('POST', '/admin/slide/{id}/upload', [$slideController, 'uploadPhoto'], $auth);

$router->create('GET', '/admin/slide/{id}/active', [$slideController, 'active'], $auth);

/////about
$router->create('GET', '/admin/paginas', [$paginaController, 'index'], $auth);

$router->create('GET', '/admin/pagina', [$paginaController, 'create'], $auth);

$router->create('POST', '/admin/pagina', [$paginaController, 'store'], $auth);

$router->create('GET', '/admin/pagina/{id}', [$paginaController, 'edit'], $auth);

$router->create('POST', '/admin/pagina/{id}', [$paginaController, 'update'], $auth);

$router->create('DELETE', '/admin/pagina/{id}', [$paginaController, 'destroy'], $auth);

$router->create('POST', '/admin/pagina/{id}/upload', [$paginaController, 'uploadPhoto'], $auth);

$router->create('GET', '/admin/pagina/{id}/active', [$paginaController, 'active'], $auth);

/////line
$router->create('GET', '/admin/linhas', [$linhaController, 'index'], $auth);

$router->create('GET', '/admin/linha', [$linhaController, 'create'], $auth);

$router->create('POST', '/admin/linha', [$linhaController, 'store'], $auth);

$router->create('GET', '/admin/linha/{id}', [$linhaController, 'edit'], $auth);

$router->create('POST', '/admin/linha/{id}', [$linhaController, 'update'], $auth);

$router->create('DELETE', '/admin/linha/{id}', [$linhaController, 'destroy'], $auth);

$router->create('GET', '/admin/linha/{id}/active', [$linhaController, 'active'], $auth);

/////documents
$router->create('GET', '/admin/documentos', [$documentoController, 'index'], $auth);

$router->create('GET', '/admin/documento', [$documentoController, 'create'], $auth);

$router->create('POST', '/admin/documento', [$documentoController, 'store'], $auth);

$router->create('GET', '/admin/documento/{id}', [$documentoController, 'edit'], $auth);

$router->create('POST', '/admin/documento/{id}', [$documentoController, 'update'], $auth);

$router->create('DELETE', '/admin/documento/{id}', [$documentoController, 'destroy'], $auth);

$router->create('GET', '/admin/documento/{id}/active', [$documentoController, 'active'], $auth);

return $router;