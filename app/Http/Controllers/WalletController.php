<?php

namespace App\Http\Controllers;

use App\User;
use App\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WalletController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
    /**
     * Display a listing of the resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $client)
    {
      $date = Carbon::now();
      $wallets = $client->wallets()
        ->whereMonth('created_at', '=', $date)
        ->orderBy('created_at','DESC')->get();
      $total = $wallets->sum('amount');
      return view('wallets.index', compact('wallets','client', 'total'));
    }
    //para seleccionar el mes
    public function month(User $client)
    {
      return view('wallets.select',compact('client'));
    }
    // busca en funcion al cliente ganancias del mes.
    public function search(Request $request, User $client)
    {
      $now= Carbon::now()->startOfMonth();
      $month = Carbon::parse($request->date)->startofMonth();
      if($month<$now)
      {
        $wallets = $client->wallets()
          ->whereMonth('created_at', '=', $month)
          ->orderBy('created_at','DESC')->get();
        $total = $wallets->sum('amount');
        $quantitys = $client->details()
          ->join('units', 'details.unit_id','=', 'units.id')
          ->select(DB::raw('units.quantity *details.quantity as total'))
          ->whereMonth('details.created_at', '=', $month)
          ->get();
        $quantity= $quantitys->sum('total');
        //return $wallets;
      return view('payments.index',compact('client', 'wallets', 'total', 'quantity','month'));
        //en el form. si hay deleted at diferente de null, ya se pago. verificar doble;
      }
      else {
        $mensaje = "la fecha debe ser al menos un mes anterior";
        return view('wallets.select',compact('client','mensaje'));
      }

    }
    public function list(User $client)
    {
      $wallets = $client->wallets()
                ->withTrashed()
                ->select('deleted_at', DB::raw('sum(amount) as total'),  DB::raw("DATE_FORMAT(created_at,'%m %Y') as months"))
                ->groupBy('months','deleted_at')
                ->orderBy('months', 'DESC')
                ->get();
      return view('payments.list', compact('client', 'wallets'));
    }
    public function payment(Request $request, User $client)
    {
      $wallets = $client->wallets()
        ->whereMonth('created_at', '=', Carbon::parse($request->date))
        ->orderBy('created_at','DESC')->delete();
      return redirect()->route('payments.list', $client->id);
    }

}
