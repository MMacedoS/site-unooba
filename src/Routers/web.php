<?php

use App\Config\AppServiceProvider;
use App\Config\Auth;
use App\Config\Container;
use App\Config\Router;
use App\Controllers\v1\Dashboard\DashboardController;
use App\Controllers\v1\NotFound\NotFoundController;
use App\Controllers\v1\Partner\ParceiroController;
use App\Controllers\v1\Sector\SetorController;
use App\Controllers\v1\Site\SiteController;
use App\Controllers\v1\User\UsuarioController;

$container = new Container();
$appServiceProvider = new AppServiceProvider($container);
$appServiceProvider->registerDependencies();

$siteController = $container->get(SiteController::class);
$dashboardController = $container->get(DashboardController::class);
$usuarioController = $container->get(UsuarioController::class);
$setorController = $container->get(SetorController::class);
$partnerController = $container->get(ParceiroController::class);

$router = new Router();
$auth = new Auth();

$notFoundController = new NotFoundController();

///site
$router->create("GET", "/", [$siteController, "index"], null);

$router->create("GET", "/sobre", [$siteController, "about"], null);

$router->create("GET", "/noticias", [$siteController, "noticias"], null);

$router->create("GET", "/noticias/{title}", [$siteController, "noticia"], null);

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

////parceiros
$router->create('GET', '/admin/partners', [$partnerController, 'index'], $auth);

$router->create('GET', '/admin/partner', [$partnerController, 'create'], $auth);

$router->create('POST', '/admin/partner', [$partnerController, 'store'], $auth);

$router->create('GET', '/admin/partner/{id}', [$partnerController, 'edit'], $auth);

$router->create('POST', '/admin/partner/{id}', [$partnerController, 'update'], $auth);

$router->create('DELETE', '/admin/partner/{id}', [$partnerController, 'destroy'], $auth);

$router->create('POST', '/admin/partner/{id}/upload', [$partnerController, 'uploadPhoto'], $auth);


return $router;