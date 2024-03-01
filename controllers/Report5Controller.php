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
 * Report5 controller
 */
class Report5Controller extends ControllerBase
{
    // summary
    #[Map(["GET", "POST", "OPTIONS"], "/Report5", [PermissionMiddleware::class], "summary.Report5")]
    public function summary(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Report5Summary");
    }
}
