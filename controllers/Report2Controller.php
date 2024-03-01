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
 * Report2 controller
 */
class Report2Controller extends ControllerBase
{
    // summary
    #[Map(["GET", "POST", "OPTIONS"], "/Report2", [PermissionMiddleware::class], "summary.Report2")]
    public function summary(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Report2Summary");
    }
}
