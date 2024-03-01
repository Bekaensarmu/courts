<?php

namespace PHPMaker2024\project2;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\project2\Attributes\Delete;
use PHPMaker2024\project2\Attributes\Get;
use PHPMaker2024\project2\Attributes\Map;
use PHPMaker2024\project2\Attributes\Options;
use PHPMaker2024\project2\Attributes\Patch;
use PHPMaker2024\project2\Attributes\Post;
use PHPMaker2024\project2\Attributes\Put;

/**
 * Dashboard1 controller
 */
class Dashboard1Controller extends ControllerBase
{
    // dashboard
    #[Map(["GET", "POST", "OPTIONS"], "/Dashboard1", [PermissionMiddleware::class], "dashboard.Dashboard1")]
    public function dashboard(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Dashboard1");
    }
}
