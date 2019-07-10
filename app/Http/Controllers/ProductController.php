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
}
