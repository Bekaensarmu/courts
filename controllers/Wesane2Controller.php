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
 * wesane2 controller
 */
class Wesane2Controller extends ControllerBase
{
    // crosstab
    #[Map(["GET", "POST", "OPTIONS"], "/Wesane2", [PermissionMiddleware::class], "crosstab.wesane2")]
    public function crosstab(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Wesane2Crosstab");
    }
}
