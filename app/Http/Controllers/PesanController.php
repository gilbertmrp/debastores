<?php

namespace App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Barang;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\PesananDetail;
use Illuminate\Support\Facades\DB;


class PesanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $barang = Barang::where('id', $id)->first();
        $jumlah = PesananDetail::all();
        return view('user.pesan.index', [
            "title" => 'Pemesanan Menu'
        ], compact('barang','jumlah'));
    }


    public function pesan(Request $request, $id)
    {
        $request->input();
        $barang     = Barang::where('id', $id)->first();
        $tanggal    = Carbon::now();

        $cek_pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

        //cek order detail

        // Validate whether it exceeds the stock quantity
        if($request->jumlah_pesan > $barang->stok)
        {
            return redirect('pesan/'.$id)->with('toast_error', 'Anda sudah melebihi batas stok');
        }elseif(!empty($cek_pesanan)){
            $cek_pesanan_detail   = PesananDetail::where('barang_id', $barang->id)->where('pesanan_id', $cek_pesanan->id)->first();
            if(!empty($cek_pesanan_detail)){
                if($request->jumlah_pesan + $cek_pesanan_detail->jumlah > $barang->stok){
                    return redirect()->back()->with('toast_info', 'Stok yang ada dipesanan anda, sudah melebihi stok yang tersedia. Silahkan cek kerangjang anda!');
                }
            }
        }

        // Cek Validation
        $cek_order = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

        // Save to database pesanan
        if(empty($cek_order))
        {
            $pesanan = new Pesanan;
            $pesanan->user_id = Auth::user()->id;
            $pesanan->tanggal = $tanggal;
            $pesanan->status = 0;
            $pesanan->jumlah_harga = 0;
            $pesanan->kode = mt_rand(1000, 9999);
            $pesanan->address = $request->address;
            $pesanan->barang_id = $barang->id;
            $pesanan->jumlah_pesan = $request->jumlah_pesan;
            $pesanan->save();

        }

          // Save to database pesanan_detail

        $pesanan_baru = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

        //cek order detail
        $cek_pesanan_detail   = PesananDetail::where('barang_id', $barang->id)->where('pesanan_id', $pesanan_baru->id)->first();

        if(empty($cek_pesanan_detail))
        {
            $pesanan_detail = new PesananDetail;
            $pesanan_detail->barang_id = $barang->id;
            $pesanan_detail->pesanan_id = $pesanan_baru->id;
            $pesanan_detail->jumlah = $request->jumlah_pesan;
            $pesanan_detail->jumlah_harga = $barang->harga*$request->jumlah_pesan;
            $pesanan_detail->save();
        }
        else
        {
            $pesanan_detail   = PesananDetail::where('barang_id', $barang->id)->where('pesanan_id', $pesanan_baru->id)->first();
            $pesanan_detail->jumlah         = $pesanan_detail->jumlah+$request->jumlah_pesan;

            // Harga sekarang
            $harga_pesanan_detail_baru      = $barang->harga*$request->jumlah_pesan;
            $pesanan_detail->jumlah_harga   = $pesanan_detail->jumlah_harga+$harga_pesanan_detail_baru;
            $pesanan_detail->update();
        }

        // total number
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
        $pesanan->jumlah_harga = $pesanan->jumlah_harga + $barang->harga*$request->jumlah_pesan;
        $pesanan->update();

        return redirect('checkout')->with('toast_success', 'Berhasil Menambah Keranjang');
    }

    public function check_out()
    {
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
 	    $pesanan_details = [];
        if(!empty($pesanan))
        {
            $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();

        }

        return view('user.pesan.checkout', [
            "title" => 'Check Out'
        ], compact('pesanan', 'pesanan_details',));
    }

    public function delete($id)
    {
        $pesanan_detail = PesananDetail::where('id', $id)->first();

        $pesanan = Pesanan::where('id', $pesanan_detail->pesanan_id)->first();
        $pesanan->jumlah_harga = $pesanan->jumlah_harga-$pesanan_detail->jumlah_harga;
        $pesanan->update();


        $pesanan_detail->delete();

        // Alert::error('Pesanan Sukses Dihapus', 'Hapus');
        return redirect('checkout')->with('toast_error', 'Berhasil Menghapus dari keranjang');;
    }



    public function konfirmasi()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if(empty($user->alamat))
        {
            return redirect('profile')->with('toast_error', 'Lengkapi Alamat Anda');
        }

        if(empty($user->nohp))
        {
            return redirect('profile')->with('toast_error', 'Lengkapi No Hp Anda');
        }

        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
        $pesanan_id = $pesanan->id;
        $pesanan->status = 1;
        $pesanan->update();

        $pesanan_details = PesananDetail::where('pesanan_id', $pesanan_id)->get();
        foreach ($pesanan_details as $pesanan_detail) {
            $barang = Barang::where('id', $pesanan_detail->barang_id)->first();
            $barang->stok = $barang->stok-$pesanan_detail->jumlah;
            $barang->update();
        }


        return redirect('history/'.$pesanan_id)->with('success', 'CheckOut berhasil silahkan lakukan pembayaran');
    }

    public function orderDetails() {
        $dataOrders = Pesanan::orderBy('updated_at', 'desc')->where('status', 2)->paginate(10);
        return view('admin.orders', [
            "title" => 'Data Pemesanan'
        ], compact('dataOrders'));
    }

    public function confirmOrdersProcess($id) {
        $dataConfirmProcess = Pesanan::where('id', $id)->first();
        $dataConfirmProcess->status = 3;
        $dataConfirmProcess->update();
        return redirect()->route('oder.deatail')->with('toast_success', 'Data has been confirmed');
    }

    public function orderResult(Request $request) {
        if($request->has('search')) {
            $dataResult = Pesanan::where('kode', 'LIKE', '%'.$request->search.'%')->paginate(10);
        }else{
            $dataResult = Pesanan::orderBy('created_at', 'desc')->where('status', 5)->paginate(10);
        }
        return view('admin.order-result', [
            "title" => 'Pemesanan Selesai'
        ], compact('dataResult'));
    }

    public function orderResultUpload($id) {
        $orderResultUpload = Pesanan::find($id);
        return view('admin.order-upload-result', [
            "title" => 'Hasil Upload Gambar'
        ], compact('orderResultUpload'));
    }

    public function resultFile($id) {
        $dataResultFile = Pesanan::find($id);
        return view('admin.result-file', [
            "title" => 'Hasil File'
        ], compact('dataResultFile'));
    }

    public function confirmPhoto() {
        $dataConfirmPhoto = Pesanan::where('status', '3')->paginate(10);
        return view('admin.confirm-photo', [
            'title' => 'Confirm Photo'
        ], compact('dataConfirmPhoto'));
    }

    public function confirmPhotoProcess(Request $request, $id) {
        // dd($request);
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $dataConfirmPhotoProcess = Pesanan::where('id', $id)->first();
        if($request->hasFile('img')) {
            $request->file('img')->move('productimage/', $request->file('img')->getClientOriginalName());
            $dataConfirmPhotoProcess->img = $request->file('img')->getClientOriginalName();
            $dataConfirmPhotoProcess->status = 4;
            $dataConfirmPhotoProcess->update();
        }
        
        return redirect()->route('confirm.photo')->with('Bukti foto berhasil di upload')->with('toast_success', 'Bukti berhasil di upload');
    }

    public function tracking() {
        $dataTracking = Pesanan::where('status', '4')->paginate(10);
        return view('admin.tracking', [
            "title" => 'Tracking'
        ], compact('dataTracking'));
    }

    public function formTracking($id) {
        $dataFormTracking = Pesanan::find($id);
        return view('admin.form-tracking', [
            "title" => 'Form Tracking'
        ], compact('dataFormTracking'));
    }

    public function formTrackingProcess(Request $request, $id) {
        // return $request;
        // dd($request->all());
        $request->validate([
            'nama_pengirim' => 'required',
            'tlpn' => 'required',
            'angkutan' => 'required',
            'jenis' => 'required',
            'plat' => 'required',
            'kurir' => 'required',
            'resi' => 'required',
        ]);

        $formTracking = Pesanan::where('id', $id)->first();
        $formTracking->nama_pengirim = $request->nama_pengirim;
        $formTracking->tlpn = $request->tlpn;
        $formTracking->angkutan = $request->angkutan;
        $formTracking->jenis = $request->jenis;
        $formTracking->plat = $request->plat;
        $formTracking->kurir = $request->kurir;
        $formTracking->resi = $request->resi;
        $formTracking->status = 5;
        $formTracking->update();

        return redirect()->route('order.tracking')->with('toast_success', 'Data berhasil tersimpan');
    }
}
