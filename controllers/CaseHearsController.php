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

class CaseHearsController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/CaseHearsList[/{id}]", [PermissionMiddleware::class], "list.case_hears")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CaseHearsList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/CaseHearsAdd[/{id}]", [PermissionMiddleware::class], "add.case_hears")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CaseHearsAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/CaseHearsView[/{id}]", [PermissionMiddleware::class], "view.case_hears")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CaseHearsView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/CaseHearsEdit[/{id}]", [PermissionMiddleware::class], "edit.case_hears")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CaseHearsEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/CaseHearsDelete[/{id}]", [PermissionMiddleware::class], "delete.case_hears")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CaseHearsDelete");
    }
}
