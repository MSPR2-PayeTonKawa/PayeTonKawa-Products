<?php

namespace App\OpenApi;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *   title="PayeTonKawa - Products API",
 *   version="1.0.0",
 *   description="Endpoints du microservice Products (CRUD + filtres)."
 * )
 *
 * @OA\SecurityScheme(
 *   securityScheme="InternalApiKey",
 *   type="apiKey",
 *   in="header",
 *   name="X-Internal-Api-Key"
 * )
 *
 * @OA\Server(
 *   url="http://localhost:8002",
 *   description="Local dev"
 * )
 */
class Spec {}
