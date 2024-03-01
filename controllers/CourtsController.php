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

class CourtsController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/CourtsList[/{id}]", [PermissionMiddleware::class], "list.courts")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CourtsList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/CourtsAdd[/{id}]", [PermissionMiddleware::class], "add.courts")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CourtsAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/CourtsView[/{id}]", [PermissionMiddleware::class], "view.courts")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CourtsView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/CourtsEdit[/{id}]", [PermissionMiddleware::class], "edit.courts")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CourtsEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/CourtsDelete[/{id}]", [PermissionMiddleware::class], "delete.courts")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CourtsDelete");
    }
}
