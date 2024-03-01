<?php

namespace PHPMaker2024\project2;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\project2\Attributes\Delete;
use PHPMaker2024\project2\Attributes\Get;
use PHPMaker2024\project2\Attributes\Map;
use PHPMaker2024\project2\Attributes\Options;
use PHPMaker2024\project2\Attributes\Patch;
use PHPMaker2024\project2\Attributes\Post;
use PHPMaker2024\project2\Attributes\Put;

class AppealController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/AppealList[/{id}]", [PermissionMiddleware::class], "list.appeal")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AppealList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/AppealAdd[/{id}]", [PermissionMiddleware::class], "add.appeal")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AppealAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/AppealView[/{id}]", [PermissionMiddleware::class], "view.appeal")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AppealView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/AppealEdit[/{id}]", [PermissionMiddleware::class], "edit.appeal")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AppealEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/AppealDelete[/{id}]", [PermissionMiddleware::class], "delete.appeal")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AppealDelete");
    }
}
