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

class CaseChargesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/CaseChargesList[/{id}]", [PermissionMiddleware::class], "list.case_charges")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CaseChargesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/CaseChargesAdd[/{id}]", [PermissionMiddleware::class], "add.case_charges")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CaseChargesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/CaseChargesView[/{id}]", [PermissionMiddleware::class], "view.case_charges")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CaseChargesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/CaseChargesEdit[/{id}]", [PermissionMiddleware::class], "edit.case_charges")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CaseChargesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/CaseChargesDelete[/{id}]", [PermissionMiddleware::class], "delete.case_charges")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CaseChargesDelete");
    }
}
