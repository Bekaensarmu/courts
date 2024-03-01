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

class BarsController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/BarsList[/{id}]", [PermissionMiddleware::class], "list.bars")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BarsList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/BarsAdd[/{id}]", [PermissionMiddleware::class], "add.bars")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BarsAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/BarsView[/{id}]", [PermissionMiddleware::class], "view.bars")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BarsView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/BarsEdit[/{id}]", [PermissionMiddleware::class], "edit.bars")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BarsEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/BarsDelete[/{id}]", [PermissionMiddleware::class], "delete.bars")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BarsDelete");
    }
}
