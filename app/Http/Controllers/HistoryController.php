<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use App\Models\Barang;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\PesananDetail;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $pesanans = Pesanan::where('user_id', Auth::user()->id)->where('status', '!=',0)->get()->sortByDesc('updated_at');

        return view('user.history.index', [
            "title" => 'Pesanan'
        ], compact('pesanans'));
    }

    public function detail($id)
    {
        $pesanan = Pesanan::where('id', $id)->first();
        $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();

        return view('user.history.detail', [
            "title" => 'Pesanan | Detail Pemesanan'
        ], compact('pesanan', 'pesanan_details'));
    }

    public function history() {
        $historyPesanan = DB::table('pesanans')->where('user_id', Auth::user()->id)
        ->where('status', '=',6)
        ->orderBy('updated_at', 'desc')->paginate(10);
        return view('user.history.history', [
            "title" => 'History Pemesanan'
        ], compact('historyPesanan'));
    }

    public function historyDetail($id) {
        $historyPesanan = Pesanan::where('id', $id)->first();
        $historyDetailPesanan = PesananDetail::where('pesanan_id', $historyPesanan->id)->get(); 
        return view('user.history.detail-history', [
            "title" => 'Detail History Pemesanan'
        ], compact('historyPesanan', 'historyDetailPesanan'));
    }
}
