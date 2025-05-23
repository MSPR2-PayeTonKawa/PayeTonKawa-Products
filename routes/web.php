<?php

use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return view("welcome");
});

Route::get("/products/api/test", function () {
    return response()->json([
        "status" => "success",
        "service" => "products-api",
        "message" => "Le service Products API fonctionne correctement",
        "data" => [
            "products_count" => 24,
            "categories_count" => 5,
            "version" => "1.0.0"
        ]
    ]);
});