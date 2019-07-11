<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        return view('products.index', compact('products'));
    }
    
    public function create()
    {
        return view('products.create');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|integer',
            'stock' => 'required|integer'
        ]);

        try {
            //menyimpan data kedalam database
            $products = Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock
            ]);
            //REDIRECT KEMBALI KE HALAMAN /PRODUCT DENGAN FLASH MESSAGE SUCCESS
            return redirect('/product')->with(['success' => '<strong>' . $products->title . '</strong> Telah disimpan']);
        }catch(\Exception $e) {
            //APABILA TERDAPAT ERROR MAKA REDIRECT KE FORM INPUT
            //DAN MENAMPILKAN FLASH MESSAGE ERROR
            return redirect('/product/create')->with(['error' => $e->getMessage()]);
        }
    } 

    public function destroy($id)
    {
        $products = Product::find($id); //QUERY KEDATABASE UNTUK MENGAMBIL DATA BERDASARKAN ID
        $products->delete(); // MENGHAPUS DATA YANG ADA DIDATABASE
        return redirect('/product')->with(['success' => '</strong>' . $products->title . '</strong> Dihapus']); // DIARAHKAN KEMBALI KEHALAMAN /product
    }

    public function edit($id)
    {
        $products = Product::find($id);
        return view('products.edit', compact('products'));
    }

    public function update(Request $request, $id)
    {
        $products = Product::find($id);

        $products->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock
        ]);
        return redirect('/product')->with(['success' => '<strong>' . $products->title . '</strong> Diperbaharui']);
    }
}
