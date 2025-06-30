<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrationTablesTest extends TestCase
{
    /** @test */
    public function categories_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasTable('categories'));
        $this->assertTrue(Schema::hasColumns('categories', [
            'id', 'name'
        ]));
    }

    /** @test */
    public function products_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasTable('products'));
        $this->assertTrue(Schema::hasColumns('products', [
            'id', 'name', 'description', 'origin', 'price', 'stock', 'category_id'
        ]));
    }
}

