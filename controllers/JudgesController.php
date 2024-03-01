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

class JudgesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/JudgesList[/{id}]", [PermissionMiddleware::class], "list.judges")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JudgesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/JudgesAdd[/{id}]", [PermissionMiddleware::class], "add.judges")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JudgesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/JudgesView[/{id}]", [PermissionMiddleware::class], "view.judges")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JudgesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/JudgesEdit[/{id}]", [PermissionMiddleware::class], "edit.judges")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JudgesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/JudgesDelete[/{id}]", [PermissionMiddleware::class], "delete.judges")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "JudgesDelete");
    }
}
