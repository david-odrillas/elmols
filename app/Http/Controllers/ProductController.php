<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreProduct;
use App\Http\Requests\Product\UpdateProduct;
use App\Message;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('permission:products.index')->only('index');
      $this->middleware('permission:products.destroy')->only(['destroy','deletes', 'restore']);
      $this->middleware('permission:products.create')->only(['create', 'store']);
      $this->middleware('permission:products.edit')->only(['edit', 'update']);
    }
    public function index(Request $request)
    {
      $products = Product::select(['id', 'name'])
        ->orderBy('name', 'ASC')
        ->name($request->get('name'))
        ->paginate(10);
      return view('products.index', compact('products'));
    }
    public function deletes()
    {
      $products = Product::onlyTrashed()->get();
      return view('products.deletes', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $product = new Product;
      return view('products.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
      Product::create($request->all());
      Message::success('Producto Registrado');
      return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
      return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduct $request, Product $product)
    {
      $product->update($request->all());
      Message::success("Producto Actualizado");
      return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
      $product->delete();
      Message::danger("Producto Eliminado");
      return redirect()->route('products.index');
    }
    public function restore($product)
    {
      Product::withTrashed()->find($product)->restore();
      //$product->restore();
      Message::success("Producto Restaurado");
      return redirect()->route('products.index');
    }
}
