<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Product;
use App\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\Sale\StoreSale;
use Illuminate\Support\Facades\DB;
use App\Message;

class SaleController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('permission:sales.index')->only(['index', 'search']);
      $this->middleware('permission:sales.create')->only('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
      $name =$request->get('name');
      $products = Product::join('units', 'products.id', '=', 'units.product_id')
          ->select('products.name', 'units.volumen', 'units.price', 'units.id')
          ->where('products.name', 'LIKE', "%$name%")
          ->whereNull('units.deleted_at')
          ->get();
      if($request->ajax()) {
        return view('sales.list', compact('products'));
      }
      abort(404);
    }
    public function index()
    {
      $sales = Sale::with('user')->orderBy('created_at','Desc')->paginate(8);

      return view('sales.index',compact('sales'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSale $request)
    {
      DB::transaction(function () use ($request){
        $sale = $request->user()->sales()->create([
          'amount' => $request->input('amount'),
          'payment' => $request->input('payment'),
          'change' => $request->input('change')
        ]);

        for ($i=0; $i < count($request->unit_id); $i++) {
          $sale->details()->create([
            'unit_id' => $request->unit_id[$i],
            'quantity' => $request->quantity[$i],
          ]);
        }
      }, 2);

      Message::success('Venta Registrada');
      return redirect()->route('sales.index');
    }
}
