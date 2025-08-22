<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;


class ProductController extends Controller
{


/**
 * @OA\Get(
 *   path="/api/products",
 *   tags={"Products"},
 *   security={{"InternalApiKey": {}}},
 *   @OA\Response(
 *     response=200,
 *     description="OK",
 *     @OA\JsonContent(type="object",
 *       @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Product")),
 *       @OA\Property(property="current_page", type="integer"),
 *       @OA\Property(property="per_page", type="integer"),
 *       @OA\Property(property="total", type="integer")
 *     )
 *   )
 * )
 */

    public function index(Request $request)
    {
        $q = Product::with('category');

        if ($s = $request->query('search')) {
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%$s%")
                ->orWhere('description', 'like', "%$s%");
            });
        }

        if ($cat = $request->query('category_id')) {
            $q->where('category_id', $cat);
        }

        return $q->paginate((int) $request->query('per_page', 15));
    }

    // au-dessus de store()
/**
 * @OA\Post(
 *   path="/api/products",
 *   summary="Créer un produit",
 *   tags={"Products"},
 *   security={{"InternalApiKey": {}}},
 *   @OA\RequestBody(required=true,
 *     @OA\JsonContent(required={"name","price","stock","category_id"},
 *       @OA\Property(property="name", type="string"),
 *       @OA\Property(property="description", type="string", nullable=true),
 *       @OA\Property(property="origin", type="string", nullable=true),
 *       @OA\Property(property="price", type="number", format="float"),
 *       @OA\Property(property="stock", type="integer"),
 *       @OA\Property(property="category_id", type="string", format="uuid")
 *     )
 *   ),
 *   @OA\Response(response=201, description="Créé")
 * )
 */

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'origin'      => 'nullable|string|max:100',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($data);
        return response()->json($product->load('category'), 201);
    }

/**
 * @OA\Get(
 *   path="/api/products/{product}",
 *   summary="Voir un produit",
 *   tags={"Products"},
 *   security={{"InternalApiKey": {}}},
 *   @OA\Parameter(name="product", in="path", required=true, @OA\Schema(type="string", format="uuid")),
 *   @OA\Response(response=200, description="OK"),
 *   @OA\Response(response=404, description="Not Found")
 * )
 */

    public function show(Product $product)
    {
        return $product->load('category');
    }
// au-dessus de update() — tu peux déclarer PUT et PATCH ensemble
/**
 * @OA\Put(
 *   path="/api/products/{product}",
 *   summary="Remplacer un produit",
 *   tags={"Products"},
 *   security={{"InternalApiKey": {}}},
 *   @OA\Parameter(name="product", in="path", required=true, @OA\Schema(type="string", format="uuid")),
 *   @OA\RequestBody(@OA\JsonContent(
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="description", type="string", nullable=true),
 *     @OA\Property(property="origin", type="string", nullable=true),
 *     @OA\Property(property="price", type="number", format="float"),
 *     @OA\Property(property="stock", type="integer"),
 *     @OA\Property(property="category_id", type="string", format="uuid")
 *   )),
 *   @OA\Response(response=200, description="OK")
 * )
 * @OA\Patch(
 *   path="/api/products/{product}",
 *   summary="Mettre à jour un produit",
 *   tags={"Products"},
 *   security={{"InternalApiKey": {}}},
 *   @OA\Parameter(name="product", in="path", required=true, @OA\Schema(type="string", format="uuid")),
 *   @OA\RequestBody(@OA\JsonContent(
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="description", type="string", nullable=true),
 *     @OA\Property(property="origin", type="string", nullable=true),
 *     @OA\Property(property="price", type="number", format="float"),
 *     @OA\Property(property="stock", type="integer"),
 *     @OA\Property(property="category_id", type="string", format="uuid")
 *   )),
 *   @OA\Response(response=200, description="OK")
 * )
 */


    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'origin'      => 'nullable|string|max:100',
            'price'       => 'sometimes|required|numeric|min:0',
            'stock'       => 'sometimes|required|integer|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        $product->update($data);
        return $product->load('category');
    }
    
// au-dessus de destroy()
/**
 * @OA\Delete(
 *   path="/api/products/{product}",
 *   summary="Supprimer un produit",
 *   tags={"Products"},
 *   security={{"InternalApiKey": {}}},
 *   @OA\Parameter(name="product", in="path", required=true, @OA\Schema(type="string", format="uuid")),
 *   @OA\Response(response=204, description="No Content")
 * )
 */

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }

}
