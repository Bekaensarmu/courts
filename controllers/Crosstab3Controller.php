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
 * Crosstab3 controller
 */
class Crosstab3Controller extends ControllerBase
{
    // crosstab
    #[Map(["GET", "POST", "OPTIONS"], "/Crosstab3", [PermissionMiddleware::class], "crosstab.Crosstab3")]
    public function crosstab(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Crosstab3Crosstab");
    }
}
