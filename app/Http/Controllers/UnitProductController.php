<?php

namespace App\Http\Controllers;

use App\Product;
use App\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreUnit;
use App\Message;
use Illuminate\Support\Facades\DB;

class UnitProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('permission:products.index')->only('index');
      $this->middleware('permission:products.destroy')->only('destroy');
      $this->middleware('permission:products.create')->only(['create', 'store']);
      $this->middleware('permission:products.edit')->only(['edit', 'update']);
    }
    public function index(Product $product)
    {
      $units = $product->units()->orderBy('price')->get();
      return view('units.index',compact('product', 'units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
      $unit = new Unit;
      return view('units.create', compact('product', 'unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnit $request, Product $product)
    {
      $product->units()->create($request->all());
      Message::success('Unidad Registrada');
      return redirect()->route('products.units.index', $product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Unit $unit)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, Unit $unit)
    {
      return view('units.edit', compact('product', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUnit $request, Product $product, Unit $unit)
    {
      DB::transaction(function () use ($request, $product, $unit){
        $unit->delete();
        $product->units()->create($request->all());
      }, 2);
      Message::success('Unidad Registrada');
      $units = $product->units()->orderBy('price')->get();
      return redirect()->route('products.units.index', $product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Unit $unit)
    {
      $unit->delete();
      Message::danger("Unidad Eliminada");
      return redirect()->route('products.units.index', $product->id);
    }
}
