<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            // $table->string('photo')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('localisation');
            $table->string('designation');
            $table->string('marque')->nullable();
            $table->string('modele')->nullable();
            $table->string('numero_serie_ou_chassis')->nullable();
            $table->string('etat');
            $table->string('situation_exacte_du_materiel');
            $table->string('responsable');
            $table->integer('quantite');
            $table->date('date_achat')->nullable();
            $table->decimal('valeur', 15, 2)->nullable();
            $table->string('numero_piece_comptables')->nullable();
            $table->string('fournisseur')->nullable();
            $table->string('bailleur')->nullable();
            $table->string('projet')->nullable();
            $table->date('date_de_sortie')->nullable();
            $table->string('codification')->nullable();
            $table->boolean('amortis')->default(false);
            $table->boolean('deleted')->default(false);
            $table->string('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
