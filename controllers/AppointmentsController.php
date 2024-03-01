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

class AppointmentsController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/AppointmentsList[/{id}]", [PermissionMiddleware::class], "list.appointments")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AppointmentsList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/AppointmentsAdd[/{id}]", [PermissionMiddleware::class], "add.appointments")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AppointmentsAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/AppointmentsView[/{id}]", [PermissionMiddleware::class], "view.appointments")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AppointmentsView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/AppointmentsEdit[/{id}]", [PermissionMiddleware::class], "edit.appointments")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AppointmentsEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/AppointmentsDelete[/{id}]", [PermissionMiddleware::class], "delete.appointments")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AppointmentsDelete");
    }
}
