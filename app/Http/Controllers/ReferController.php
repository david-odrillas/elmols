<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreRefer;
use App\Message;

class ReferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('permission:users.index')->only('index');
      $this->middleware('permission:users.create')->only(['create', 'store']);
    }
    public function index(User $client)
    {
      $users = $client->users()->select(['id', 'name', 'ci', 'cell'])
        ->orderBy('name', 'ASC')
        ->paginate(10);
      return view('refers.index', compact('client', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function create(User $client)
    {
      return view('refers.create', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRefer $request, User $client)
    {
      $client->users()->create($request->all());
      Message::success('Referido Registrado');
      return redirect()->route('clients.refers.index', $client->id);
    }

}
