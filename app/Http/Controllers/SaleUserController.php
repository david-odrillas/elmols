<?php

namespace App\Http\Controllers;

use App\Sale;
use App\User;
use App\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\Sale\StoreSale;
use Illuminate\Support\Facades\DB;
use App\Message;
use Carbon\Carbon;
class SaleUserController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('permission:sales.index')->only('index');
      $this->middleware('permission:sales.create')->only(['create','store']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $client)
    {
      $date = Carbon::now();
      $sales = $client->sales()
        ->whereMonth('created_at', '=', $date)
        ->orderBy('created_at', 'DESC')->paginate(10);
      return view('sales.users', compact('sales','client'));
    }

    public function create(User $client)
    {
      return view('sales.clients', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSale $request, User $client)
    {
      DB::transaction(function () use ($request, $client){
        $sale = $client->sales()->create([
          'amount' => $request->input('amount'),
          'payment' => $request->input('payment'),
          'change' => $request->input('change')
        ]);

        for ($i=0; $i < count($request->unit_id); $i++) {
          $detail = $sale->details()->create([
            'unit_id' => $request->unit_id[$i],
            'quantity' => $request->quantity[$i],
          ]);
          $detail->wallets()->create([
            'user_id' => $client->id,
            'amount'  => Unit::find($request->unit_id[$i])->accumulate * $request->quantity[$i],
          ]);
          if($client->sponsor)
          {
            $detail->wallets()->create([
              'user_id' => $client->sponsor->id,
              'amount'  => Unit::find($request->unit_id[$i])->sponsor * $request->quantity[$i],
            ]);
          }
          if($client->sponsor->sponsor)
          {
            $detail->wallets()->create([
              'user_id' => $client->sponsor->sponsor->id,
              'amount'  => Unit::find($request->unit_id[$i])->supsponsor * $request->quantity[$i],
            ]);
          }
        }
      }, 2);

      Message::success('Venta Registrada');
      return redirect()->route('sales.index');
    }
}
