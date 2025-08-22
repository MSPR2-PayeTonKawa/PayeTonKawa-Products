<?php

namespace App\OpenApi;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   schema="Category",
 *   @OA\Property(property="id", type="string", format="uuid"),
 *   @OA\Property(property="name", type="string")
 * )
 *
 * @OA\Schema(
 *   schema="Product",
 *   @OA\Property(property="id", type="string", format="uuid"),
 *   @OA\Property(property="name", type="string"),
 *   @OA\Property(property="description", type="string", nullable=true),
 *   @OA\Property(property="origin", type="string", nullable=true),
 *   @OA\Property(property="price", type="number", format="float"),
 *   @OA\Property(property="stock", type="integer"),
 *   @OA\Property(property="category_id", type="string", format="uuid")
 * )
 */
class Schemas {}
