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

class UsersController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/UsersList[/{id}]", [PermissionMiddleware::class], "list.users")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsersList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/UsersAdd[/{id}]", [PermissionMiddleware::class], "add.users")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsersAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/UsersView[/{id}]", [PermissionMiddleware::class], "view.users")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsersView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/UsersEdit[/{id}]", [PermissionMiddleware::class], "edit.users")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsersEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/UsersDelete[/{id}]", [PermissionMiddleware::class], "delete.users")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsersDelete");
    }
}
