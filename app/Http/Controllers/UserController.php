<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateUser;
use Illuminate\Support\Facades\Hash;
use App\Message;


class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permission:users.index')->only('index');
    // $this->middleware('permission:users.destroy')->only(['destroy','deletes', 'restore']);
    $this->middleware('permission:users.create')->only(['create', 'store']);
    // $this->middleware('permission:users.edit')->only(['edit', 'update']);
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $users = User::select(['id', 'name', 'ci', 'cell', 'address'])
        ->orderBy('name', 'ASC')
        ->name($request->get('name'))
        ->paginate(10);
      return view('clients.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
      User::create($request->all());
      Message::success('Cliente Registrado');
      return redirect()->route('clients.index');
      //return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(User $client)
    {
      return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $client)
    {
      $client->update($request->all());
      Message::success('Cliente Actualizado');
      return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        //
    }
}
