<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_price', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->decimal('monthly', 10, 2)->nullable();
            $table->decimal('quarterly', 10, 2)->nullable();
            $table->decimal('semi_annually', 10, 2)->nullable();
            $table->decimal('annually', 10, 2)->nullable();
            $table->decimal('biennially', 10, 2)->nullable();
            $table->decimal('triennially', 10, 2)->nullable();
            $table->decimal('monthly_setup', 10, 2)->nullable();
            $table->decimal('quarterly_setup', 10, 2)->nullable();
            $table->decimal('semi_annually_setup', 10, 2)->nullable();
            $table->decimal('annually_setup', 10, 2)->nullable();
            $table->decimal('biennially_setup', 10, 2)->nullable();
            $table->decimal('triennially_setup', 10, 2)->nullable();
            $table->foreignId('product_id')->constrained('products');
            $table->timestamps();
        });
        Schema::table('order_products', function (Blueprint $table) {
            $table->string('billing_cycle')->after('price')->nullable();
        });
        $products = \App\Models\Product::all();
        foreach ($products as $product) {
            $productPrice = new \App\Models\ProductPrice();
            $productPrice->product_id = $product->id;
            if ($product->price == 0) {
                $productPrice->type = 'free';
                $productPrice->save();
            } else {
                $productPrice->type = 'recurring';
                $productPrice->monthly = $product->price;
                $productPrice->save();
            }
        }
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->string('allow_quantity')->after('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropColumn('billing_cycle');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable();
            $table->dropColumn('allow_quantity');
        });
        $productPrices = \App\Models\ProductPrice::all();
        foreach ($productPrices as $productPrice) {
            $product = \App\Models\Product::find($productPrice->product_id);
            $product->price = $productPrice->monthly;
            $product->save();
        }
        Schema::dropIfExists('product_price');
    }
};
