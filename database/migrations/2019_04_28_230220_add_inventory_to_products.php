<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class AddInventoryToProducts extends Migration { public function up() { if (!Schema::hasColumn('products', 'inventory')) { Schema::table('products', function (Blueprint $sp8280da) { $sp8280da->tinyInteger('inventory')->default(\App\User::INVENTORY_AUTO)->after('enabled'); $sp8280da->tinyInteger('fee_type')->default(\App\User::FEE_TYPE_AUTO)->after('inventory'); }); } } public function down() { foreach (array('inventory', 'fee_type') as $sp454748) { try { Schema::table('products', function (Blueprint $sp8280da) use($sp454748) { $sp8280da->dropColumn($sp454748); }); } catch (\Throwable $sp4b79b8) { } } } }