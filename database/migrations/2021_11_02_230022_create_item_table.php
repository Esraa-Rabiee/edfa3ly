<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->string('type', 255);
            $table->string('country', 255);
            $table->float('price');
            $table->float('weight');
            $table->float('rate');
            $table->timestamps();
        });

        DB::table('item')->insert(
            array(
                [
                'type' => 'T-shirt',
                'country' => 'US',
                'price' => '30.99',
                'weight' => '0.2',
                'rate' => '2'
                ],
                [
                'type' => 'Blouse',
                'country' => 'UK',
                'price' => '10.99',
                'weight' => '0.3',
                'rate' => '3'
                ],
                [
                'type' => 'Pants',
                'country' => 'UK',
                'price' => '64.99',
                'weight' => '0.9',
                'rate' => '3'
                ],
                [
                'type' => 'Sweatpants',
                'country' => 'CN',
                'price' => '84.99',
                'weight' => '1.1',
                'rate' => '2'
                ],
                [
                'type' => 'Jacket',
                'country' => 'US',
                'price' => '199.99',
                'weight' => '2.2',
                'rate' => '2'
                ],
                [
                'type' => 'Shoes',
                'country' => 'CN',
                'price' => '79.99',
                'weight' => '1.3',
                'rate' => '2'
                ]
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
    }
}
