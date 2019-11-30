<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class CreateShopThemesTable extends Migration { public function up() { Schema::create('shop_themes', function (Blueprint $sp8280da) { $sp8280da->increments('id'); $sp8280da->string('name', 128)->unique(); $sp8280da->string('description')->nullable(); $sp8280da->text('options')->nullable(); $sp8280da->text('config')->nullable(); $sp8280da->boolean('enabled')->default(true); }); \App\ShopTheme::freshList(); } public function down() { Schema::dropIfExists('shop_themes'); } }