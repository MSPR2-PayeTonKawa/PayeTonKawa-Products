<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CategoryController extends Controller
{
    /**
 * @OA\Get(
 *   path="/api/categories",
 *   tags={"Categories"},
 *   security={{"InternalApiKey": {}}},
 *   @OA\Response(
 *     response=200,
 *     description="OK",
 *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Category"))
 *   )
 * )
 */
    public function index()
    {
        return Category::orderBy('name')->get();
    }

    /**
     * @OA\Post(
     *   path="/api/categories",
     *   summary="Créer une catégorie",
     *   tags={"Categories"},
     *   security={{"InternalApiKey": {}}},
     *   @OA\RequestBody(required=true,
     *     @OA\JsonContent(required={"name"},
     *       @OA\Property(property="name", type="string")
     *     )
     *   ),
     *   @OA\Response(response=201, description="Créé")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        return response()->json(Category::create($data), 201);
    }

    /**
     * @OA\Get(
     *   path="/api/categories/{category}",
     *   summary="Voir une catégorie",
     *   tags={"Categories"},
     *   security={{"InternalApiKey": {}}},
     *   @OA\Parameter(name="category", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */
    public function show(Category $category)
    {
        return $category->load('products');
    }

    /**
     * @OA\Put(
     *   path="/api/categories/{category}",
     *   summary="Remplacer une catégorie",
     *   tags={"Categories"},
     *   security={{"InternalApiKey": {}}},
     *   @OA\Parameter(name="category", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *   @OA\RequestBody(@OA\JsonContent(@OA\Property(property="name", type="string"))),
     *   @OA\Response(response=200, description="OK")
     * )
     * @OA\Patch(
     *   path="/api/categories/{category}",
     *   summary="Mettre à jour une catégorie",
     *   tags={"Categories"},
     *   security={{"InternalApiKey": {}}},
     *   @OA\Parameter(name="category", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *   @OA\RequestBody(@OA\JsonContent(@OA\Property(property="name", type="string"))),
     *   @OA\Response(response=200, description="OK")
     * )
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($data);
        return $category;
    }

    /**
     * @OA\Delete(
     *   path="/api/categories/{category}",
     *   summary="Supprimer une catégorie",
     *   tags={"Categories"},
     *   security={{"InternalApiKey": {}}},
     *   @OA\Parameter(name="category", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *   @OA\Response(response=204, description="No Content")
     * )
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }

    /**
     * @OA\Get(
     *   path="/api/categories/{category}/products",
     *   summary="Produits d'une catégorie",
     *   tags={"Categories"},
     *   security={{"InternalApiKey": {}}},
     *   @OA\Parameter(name="category", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *   @OA\Response(response=200, description="OK")
     * )
     */
    public function products(Category $category)
    {
        return $category->products()->with('category')->paginate(15);
    }
}
