<?php

namespace App\Http\Controllers;

use App\Detail;
use App\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function index(Sale $sale)
    {

      $details = $sale->details()->join('units', 'details.unit_id','=', 'units.id')
          ->join('products', 'units.product_id', '=', 'products.id')
          ->select('details.quantity', 'units.volumen', 'products.name','units.price', DB::raw('units.price*details.quantity as total'))->get();
      return view('sales.details',compact('sale', 'details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function create(Sale $sale)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale, Detail $detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale, Detail $detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale, Detail $detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale, Detail $detail)
    {
        //
    }
}
