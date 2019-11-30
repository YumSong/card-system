<?php
namespace App\Http\Controllers; use App\System; use Illuminate\Http\Request; use Illuminate\Support\Facades\Log; use Illuminate\Support\Facades\Mail; class DevController extends Controller { private function check_readable_r($sp8b3d35) { if (is_dir($sp8b3d35)) { if (is_readable($sp8b3d35)) { $sp4bb0a5 = scandir($sp8b3d35); foreach ($sp4bb0a5 as $sp7384b9) { if ($sp7384b9 != '.' && $sp7384b9 != '..') { if (!self::check_readable_r($sp8b3d35 . '/' . $sp7384b9)) { return false; } else { continue; } } } echo $sp8b3d35 . '   ...... <span style="color: green">R</span><br>'; return true; } else { echo $sp8b3d35 . '   ...... <span style="color: red">R</span><br>'; return false; } } else { if (file_exists($sp8b3d35)) { return is_readable($sp8b3d35); } } echo $sp8b3d35 . '   ...... 文件不存在<br>'; return false; } private function check_writable_r($sp8b3d35) { if (is_dir($sp8b3d35)) { if (is_writable($sp8b3d35)) { $sp4bb0a5 = scandir($sp8b3d35); foreach ($sp4bb0a5 as $sp7384b9) { if ($sp7384b9 != '.' && $sp7384b9 != '..') { if (!self::check_writable_r($sp8b3d35 . '/' . $sp7384b9)) { return false; } else { continue; } } } echo $sp8b3d35 . '   ...... <span style="color: green">W</span><br>'; return true; } else { echo $sp8b3d35 . '   ...... <span style="color: red">W</span><br>'; return false; } } else { if (file_exists($sp8b3d35)) { return is_writable($sp8b3d35); } } echo $sp8b3d35 . '   ...... 文件不存在<br>'; return false; } private function checkPathPermission($sp189f81) { self::check_readable_r($sp189f81); self::check_writable_r($sp189f81); } public function install() { $spb61dad = array(); @ob_start(); self::checkPathPermission(base_path('storage')); self::checkPathPermission(base_path('bootstrap/cache')); $spb61dad['permission'] = @ob_get_clean(); return view('install', array('var' => $spb61dad)); } public function test(Request $spfb41ce) { } }