<?php
ob_start();

require __DIR__."/vendor/autoload.php";

use CoffeeCode\Router\Router;
use Source\Core\Session;

$session = new Session();
$route = new Router(ROOT);
$route->namespace("Source\App");

/**
 *WEB ROUTES
 */

$route->group(null);
$route->get("/", "Web:home");
$route->get("/{page}", "Web:home");
$route->post("/plan", "Web:plan");

$route->get("/login", "Web:login");
$route->post("/login", "Web:login");

/**
 *ADMIN ROUTES
 */

$route->group("admin");

$route->get("/planos", "PlanController:planArea");
$route->post("/planos", "PlanController:planosCreate");
$route->get("/planos/excluir/{id}", "PlanController:planDelete");
$route->get("/planos/editar/{id}", "PlanController:planEdit");
$route->post("/planos/editar/{id}", "PlanController:planUpdate");

$route->get("/dash", "CallController:callArea");
$route->post("/call", "CallController:callCreate");
$route->get("/call/excluir/{id}", "CallController:callDelete");
$route->get("/call/editar/{id}", "CallController:callEdit");
$route->post("/call/editar/{id}", "CallController:callUpdate");

$route->get("/sair", "Web:exit");


/**
 *ERROR ROUTES
 */
$route->group("ops");
$route->get("/{errcode}", "Web:error");

/**
 *PROCESS ROUTES
 */
$route->dispatch();

if ($route->error()){
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();
