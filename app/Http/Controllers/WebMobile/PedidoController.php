<?php

namespace App\Http\Controllers\WebMobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PedidoController extends Controller
{
    public function index()
    {
        return view('webmobile.pedidos');
    }
}