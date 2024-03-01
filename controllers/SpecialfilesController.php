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

class SpecialfilesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/SpecialfilesList[/{sid}]", [PermissionMiddleware::class], "list.specialfiles")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SpecialfilesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/SpecialfilesAdd[/{sid}]", [PermissionMiddleware::class], "add.specialfiles")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SpecialfilesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/SpecialfilesView[/{sid}]", [PermissionMiddleware::class], "view.specialfiles")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SpecialfilesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/SpecialfilesEdit[/{sid}]", [PermissionMiddleware::class], "edit.specialfiles")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SpecialfilesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/SpecialfilesDelete[/{sid}]", [PermissionMiddleware::class], "delete.specialfiles")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SpecialfilesDelete");
    }
}
