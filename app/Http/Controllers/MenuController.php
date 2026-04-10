<?php

namespace App\Http\Controllers; 

use App\Models\Menu;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        $query = Menu::with('vendor');

        if (Auth::check() && Auth::user()->idvendor) {
            $query->where('idvendor', Auth::user()->idvendor);
        }

        $menus = $query->orderByDesc('idmenu')->get();
        $vendors = Vendor::orderBy('nama_vendor')->get();

        return view('vendor.index', compact('menus', 'vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'idvendor' => 'required|exists:vendor,idvendor',
            'path_gambar' => 'nullable|string|max:255',
        ]);
        
        Menu::create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'idvendor' => $request->idvendor,
            'path_gambar' => $request->path_gambar,
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambah!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'idvendor' => 'required|exists:vendor,idvendor',
            'path_gambar' => 'nullable|string|max:255',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'idvendor' => $request->idvendor,
            'path_gambar' => $request->path_gambar,
        ]);

        return redirect()->back()->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    public function getAllVendor()
    {
        return response()->json(Vendor::all());
    }

    public function getMenuByVendor($idvendor)
    {
        $menus = Menu::where('idvendor', $idvendor)
            ->orderBy('nama_menu')
            ->get(['idmenu', 'nama_menu', 'harga', 'path_gambar', 'idvendor']);

        return response()->json($menus);
    }

    public function getMenuDetail($idmenu)
    {
        return response()->json(Menu::findOrFail($idmenu));
    }
}