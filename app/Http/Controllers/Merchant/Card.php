<?php
namespace App\Http\Controllers\Merchant; use App\Library\Response; use App\System; use Illuminate\Http\Request; use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Auth; use Illuminate\Support\Facades\DB; use Illuminate\Support\Facades\Storage; class Card extends Controller { function get(Request $spfb41ce, $sp378022 = false, $spb96ee9 = false, $spe5793c = false) { $sp61dd0f = $this->authQuery($spfb41ce, \App\Card::class)->with(array('product' => function ($sp61dd0f) { $sp61dd0f->select(array('id', 'name')); })); $sp2e420a = $spfb41ce->input('search', false); $sp286c56 = $spfb41ce->input('val', false); if ($sp2e420a && $sp286c56) { if ($sp2e420a == 'id') { $sp61dd0f->where('id', $sp286c56); } else { $sp61dd0f->where($sp2e420a, 'like', '%' . $sp286c56 . '%'); } } $spf9ba01 = (int) $spfb41ce->input('category_id'); $sp2fece4 = $spfb41ce->input('product_id', -1); if ($spf9ba01 > 0) { if ($sp2fece4 > 0) { $sp61dd0f->where('product_id', $sp2fece4); } else { $sp61dd0f->whereHas('product', function ($sp61dd0f) use($spf9ba01) { $sp61dd0f->where('category_id', $spf9ba01); }); } } $spd2b17f = $spfb41ce->input('status'); if (strlen($spd2b17f)) { $sp61dd0f->whereIn('status', explode(',', $spd2b17f)); } $sp2aebc5 = (int) $spfb41ce->input('onlyCanSell'); if ($sp2aebc5) { $sp61dd0f->whereRaw('`count_all`>`count_sold`'); } $spc5c8dd = $spfb41ce->input('type'); if (strlen($spc5c8dd)) { $sp61dd0f->whereIn('type', explode(',', $spc5c8dd)); } $sp5c7120 = $spfb41ce->input('trashed') === 'true'; if ($sp5c7120) { $sp61dd0f->onlyTrashed(); } if ($spb96ee9 === true) { if ($sp5c7120) { $sp61dd0f->forceDelete(); } else { \App\Card::_trash($sp61dd0f); } return Response::success(); } else { if ($sp5c7120 && $spe5793c === true) { \App\Card::_restore($sp61dd0f); return Response::success(); } else { $sp61dd0f->orderByRaw('`product_id`,`type`,`status`,`id`'); if ($sp378022 === true) { $spda0630 = ''; $sp61dd0f->chunk(100, function ($spc5023f) use(&$spda0630) { foreach ($spc5023f as $sp38ab38) { $spda0630 .= $sp38ab38->card . '
'; } }); $sp340d35 = 'export_cards_' . $this->getUserIdOrFail($spfb41ce) . '_' . date('YmdHis') . '.txt'; $sp5f2049 = array('Content-type' => 'text/plain', 'Content-Disposition' => sprintf('attachment; filename="%s"', $sp340d35), 'Content-Length' => strlen($spda0630)); return response()->make($spda0630, 200, $sp5f2049); } $sp91e8e3 = $spfb41ce->input('current_page', 1); $sp3cad87 = $spfb41ce->input('per_page', 20); $sp32d442 = $sp61dd0f->paginate($sp3cad87, array('*'), 'page', $sp91e8e3); return Response::success($sp32d442); } } } function export(Request $spfb41ce) { return self::get($spfb41ce, true); } function trash(Request $spfb41ce) { $this->validate($spfb41ce, array('ids' => 'required|string')); $sp87851e = $spfb41ce->post('ids'); $sp61dd0f = $this->authQuery($spfb41ce, \App\Card::class)->whereIn('id', explode(',', $sp87851e)); \App\Card::_trash($sp61dd0f); return Response::success(); } function restoreTrashed(Request $spfb41ce) { $this->validate($spfb41ce, array('ids' => 'required|string')); $sp87851e = $spfb41ce->post('ids'); $sp61dd0f = $this->authQuery($spfb41ce, \App\Card::class)->whereIn('id', explode(',', $sp87851e)); \App\Card::_restore($sp61dd0f); return Response::success(); } function deleteTrashed(Request $spfb41ce) { $this->validate($spfb41ce, array('ids' => 'required|string')); $sp87851e = $spfb41ce->post('ids'); $this->authQuery($spfb41ce, \App\Card::class)->whereIn('id', explode(',', $sp87851e))->forceDelete(); return Response::success(); } function deleteAll(Request $spfb41ce) { return $this->get($spfb41ce, false, true); } function restoreAll(Request $spfb41ce) { return $this->get($spfb41ce, false, false, true); } function add(Request $spfb41ce) { $sp2fece4 = (int) $spfb41ce->post('product_id'); $spc5023f = $spfb41ce->post('card'); $spc5c8dd = (int) $spfb41ce->post('type', \App\Card::TYPE_ONETIME); $sp1e7fb9 = $spfb41ce->post('is_check') === 'true'; if (str_contains($spc5023f, '<') || str_contains($spc5023f, '>')) { return Response::fail('卡密不能包含 < 或 > 符号'); } $sp1e2a07 = $this->getUserIdOrFail($spfb41ce); $spea68a6 = $this->authQuery($spfb41ce, \App\Product::class)->where('id', $sp2fece4); $spea68a6->firstOrFail(array('id')); if ($spc5c8dd === \App\Card::TYPE_REPEAT) { if ($sp1e7fb9) { if (\App\Card::where('product_id', $sp2fece4)->where('card', $spc5023f)->exists()) { return Response::fail('该卡密已经存在，添加失败'); } } $sp38ab38 = new \App\Card(array('user_id' => $sp1e2a07, 'product_id' => $sp2fece4, 'card' => $spc5023f, 'type' => \App\Card::TYPE_REPEAT, 'count_sold' => 0, 'count_all' => (int) $spfb41ce->post('count_all', 1))); if ($sp38ab38->count_all < 1 || $sp38ab38->count_all > 10000000) { return Response::forbidden('可售总次数不能超过10000000'); } return DB::transaction(function () use($spea68a6, $sp38ab38) { $sp38ab38->saveOrFail(); $spae5d03 = $spea68a6->lockForUpdate()->firstOrFail(); $spae5d03->count_all += $sp38ab38->count_all; $spae5d03->saveOrFail(); return Response::success(); }); } else { $sp3042f3 = explode('
', $spc5023f); $spc8631f = count($sp3042f3); $spb66098 = 500; if ($spc8631f > $spb66098) { return Response::fail('每次添加不能超过 ' . $spb66098 . ' 张'); } $sp64e7f2 = array(); if ($sp1e7fb9) { $sp27e5b6 = \App\Card::where('user_id', $sp1e2a07)->where('product_id', $sp2fece4)->get(array('card'))->all(); foreach ($sp27e5b6 as $sp8efb25) { $sp64e7f2[] = $sp8efb25['card']; } } $sp407447 = array(); $spf30ae9 = 0; for ($spdb14d1 = 0; $spdb14d1 < $spc8631f; $spdb14d1++) { $sp5a803c = trim($sp3042f3[$spdb14d1]); if (strlen($sp5a803c) < 1) { continue; } if (strlen($sp5a803c) > 255) { return Response::fail('第 ' . $spdb14d1 . ' 张卡密 ' . $sp5a803c . ' 长度错误<br>卡密最大长度为255'); } if ($sp1e7fb9) { if (in_array($sp5a803c, $sp64e7f2)) { continue; } $sp64e7f2[] = $sp5a803c; } $sp407447[] = array('user_id' => $sp1e2a07, 'product_id' => $sp2fece4, 'card' => $sp5a803c, 'type' => \App\Card::TYPE_ONETIME); $spf30ae9++; } if ($spf30ae9 === 0) { return Response::success(); } return DB::transaction(function () use($spea68a6, $sp407447, $spf30ae9) { \App\Card::insert($sp407447); $spae5d03 = $spea68a6->lockForUpdate()->firstOrFail(); $spae5d03->count_all += $spf30ae9; $spae5d03->saveOrFail(); return Response::success(); }); } } function edit(Request $spfb41ce) { $sp1e9761 = (int) $spfb41ce->post('id'); $sp38ab38 = $this->authQuery($spfb41ce, \App\Card::class)->findOrFail($sp1e9761); if ($sp38ab38) { $sp9de3bf = $spfb41ce->post('card'); $spc5c8dd = (int) $spfb41ce->post('type', \App\Card::TYPE_ONETIME); $sp47b0b2 = (int) $spfb41ce->post('count_all', 1); return DB::transaction(function () use($sp38ab38, $sp9de3bf, $spc5c8dd, $sp47b0b2) { $sp38ab38 = \App\Card::where('id', $sp38ab38->id)->lockForUpdate()->firstOrFail(); $sp38ab38->card = $sp9de3bf; $sp38ab38->type = $spc5c8dd; if ($sp38ab38->type === \App\Card::TYPE_REPEAT) { if ($sp47b0b2 < $sp38ab38->count_sold) { return Response::forbidden('可售总次数不能低于当前已售次数'); } if ($sp47b0b2 < 1 || $sp47b0b2 > 10000000) { return Response::forbidden('可售总次数不能超过10000000'); } $sp38ab38->count_all = $sp47b0b2; } else { $sp38ab38->count_all = 1; } $sp38ab38->saveOrFail(); $spae5d03 = $sp38ab38->product()->lockForUpdate()->firstOrFail(); $spae5d03->count_all -= $sp38ab38->count_all; $spae5d03->count_all += $sp47b0b2; $spae5d03->saveOrFail(); return Response::success(); }); } return Response::success(); } }