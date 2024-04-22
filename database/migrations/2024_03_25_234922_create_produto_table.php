<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProdutoTable extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->text('descricao')->nullable();
            $table->unsignedBigInteger('categorias_id')->nullable();
            $table->foreign('categorias_id')->references('id')->on('categorias')->onDelete('set null');
            $table->string('fabricante', 100)->nullable();
            $table->string('codigo', 50)->nullable();
            $table->decimal('precounitario', 10, 2)->nullable();
            $table->string('fat', 50)->nullable();
            $table->string('moeda', 10)->nullable();
            $table->string('origempreco', 50)->nullable();
            $table->decimal('totaladotado', 10, 2)->nullable();
            $table->decimal('percentualdesconto', 5, 2)->nullable();
            $table->string('sistema', 50)->nullable();
            $table->string('unidade_medida')->nullable();;
            $table->string('status')->nullable();
            $table->timestamps();
        });
        DB::table('produtos')->insert(
            [
                ['nome' => 'Chapa galvanizada #26', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Chapa galvanizada #24', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Chapa galvanizada #22', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Chapa galvanizada #20', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Chapa galvanizada #18', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Chapa preta #16', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Chapa Alumínio #24', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Chapa Alumínio #22', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Chapa Alumínio #20', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Chapa Inox 304', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Isolamento em manta de lã de vidro 38 mm', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Isolamento em manta cerâmica 38 mm e densidade de 96 kg/m³', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Acessórios (Cantoneira em chapa / Barra roscada 3/8" / perfilado 38 x 38 mm / fita aluminizada)', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Canto TDC + Porcas + Parafusor', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Flexível', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Colarinho com ou sem registro', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Duto PVC', 'categorias_id' => 1, 'status' => 'A'],
                ['nome' => 'Pintura', 'categorias_id' => 1, 'status' => 'A'],
            ]
        );

    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
