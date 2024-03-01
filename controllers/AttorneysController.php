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

class AttorneysController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/AttorneysList[/{id}]", [PermissionMiddleware::class], "list.attorneys")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AttorneysList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/AttorneysAdd[/{id}]", [PermissionMiddleware::class], "add.attorneys")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AttorneysAdd");
    }
}
