<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class MenuController extends Controller
{
    public function index() {
        $dataMenu = Barang::paginate(5);
        return view('admin.menu.index', [
            "title" => 'Data Menu'
        ], compact('dataMenu'));
    }

    public function menu() {
        return view('admin.menu.add' , [
            "title" => "Tambah Data Menu"
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required',
            'keterangan' => 'required',
            'stok' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $menu = Barang::create([
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
            'stok' => $request->stok,
            'gambar' => $request->gambar,
        ]);

        if($request->hasFile('gambar')) {
            $request->file('gambar')->move('productimage/', $request->file('gambar')->getClientOriginalName());
            $menu->gambar = $request->file('gambar')->getClientOriginalName();
            $menu->save();
        }

        return redirect()->route('menu')->with('toast_success', 'Sukses, menu berhasil ditambahkan');
    }

    public function getUpdate($id) {
        $dataMenuUpdate = Barang::find($id);
        return view('admin.menu.edit', [
            "title" => 'Edit Data Menu'
        ], compact('dataMenuUpdate'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required',
            'keterangan' => 'required',
            'stok' => 'required',
            ]);
            $update = ['nama_barang' => $request->nama_barang, 'harga' => $request->harga, 'keterangan' => $request->keterangan, 'stok' => $request->stok];
            if ($files = $request->file('gambar')) {
            $destinationPath = 'productimage/'; // upload path
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalName();
            $files->move($destinationPath, $profileImage);
            $update['gambar'] = "$profileImage";
            }
            $update['nama_barang'] = $request->get('nama_barang');
            $update['harga'] = $request->get('harga');
            $update['keterangan'] = $request->get('keterangan');
            $update['stok'] = $request->get('stok');
            Barang::where('id',$id)->update($update);
            return Redirect::to('menu')
            ->with('toast_success','Sukses, Menu berhasil di update');
    }

    
    public function delete($id) {
        $data = Barang::find($id);
        $data->delete();
        return redirect()->route('menu')->with('toast_success', 'Produk berhasil dihapus');
    }

    public function menuUser() {
        $dataMenu = Barang::all();
        return view('user.menu', [
            "title" => 'List Menu'
        ], compact('dataMenu'));
    }
}
