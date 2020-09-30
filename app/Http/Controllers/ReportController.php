<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function select()
  {
    $products = Product::all();
    return view('reports.select',compact('products'));
  }
  public function today(Request $request)
  {
    $date = Carbon::now();
    $products = Product::join('units', 'units.product_id','=', 'products.id')
      ->join('details', 'details.unit_id', '=', 'units.id')
      ->select('products.name', 'details.quantity', 'units.volumen', 'details.sale_id',DB::raw('units.quantity *details.quantity as total'))
      ->whereDay('details.created_at', '=', $date)
      ->where('products.id',$request->product)
      ->get();
    return view('reports.sales',compact('products'));
  }
  public function day(Request $request)
  {
    $date = Carbon::parse($request->date);
    $products = Product::join('units', 'units.product_id','=', 'products.id')
      ->join('details', 'details.unit_id', '=', 'units.id')
      ->select('products.name', 'details.quantity', 'units.volumen', 'details.sale_id',DB::raw('units.quantity *details.quantity as total'))
      ->whereDay('details.created_at', '=', $date)
      ->where('products.id',$request->product)
      ->get();
    return view('reports.sales',compact('products'));
  }
  public function month(Request $request)
  {
    $date = Carbon::parse($request->date);
    $products = Product::join('units', 'units.product_id','=', 'products.id')
      ->join('details', 'details.unit_id', '=', 'units.id')
      ->select('products.name', 'details.quantity', 'units.volumen', 'details.sale_id',DB::raw('units.quantity *details.quantity as total'))
      ->whereMonth('details.created_at', '=', $date)
      ->where('products.id',$request->product)
      ->get();
    return view('reports.sales',compact('products'));
  }public function range(Request $request)
  {
    $from = Carbon::parse($request->star);
    $to = Carbon::parse($request->end);
    $products = Product::join('units', 'units.product_id','=', 'products.id')
      ->join('details', 'details.unit_id', '=', 'units.id')
      ->select('products.name', 'details.quantity', 'units.volumen', 'details.sale_id',DB::raw('units.quantity *details.quantity as total'))
      ->whereBetween('details.created_at', [$from, $to])
      ->where('products.id',$request->product)
      ->get();
    return view('reports.sales',compact('products'));
  }
}
