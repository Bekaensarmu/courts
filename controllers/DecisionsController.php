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

class DecisionsController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/DecisionsList[/{id}]", [PermissionMiddleware::class], "list.decisions")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DecisionsList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/DecisionsAdd[/{id}]", [PermissionMiddleware::class], "add.decisions")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DecisionsAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/DecisionsView[/{id}]", [PermissionMiddleware::class], "view.decisions")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DecisionsView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/DecisionsEdit[/{id}]", [PermissionMiddleware::class], "edit.decisions")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DecisionsEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/DecisionsDelete[/{id}]", [PermissionMiddleware::class], "delete.decisions")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DecisionsDelete");
    }
}
