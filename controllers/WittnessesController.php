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

class WittnessesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/WittnessesList[/{id}]", [PermissionMiddleware::class], "list.wittnesses")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "WittnessesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/WittnessesAdd[/{id}]", [PermissionMiddleware::class], "add.wittnesses")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "WittnessesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/WittnessesView[/{id}]", [PermissionMiddleware::class], "view.wittnesses")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "WittnessesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/WittnessesEdit[/{id}]", [PermissionMiddleware::class], "edit.wittnesses")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "WittnessesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/WittnessesDelete[/{id}]", [PermissionMiddleware::class], "delete.wittnesses")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "WittnessesDelete");
    }
}
