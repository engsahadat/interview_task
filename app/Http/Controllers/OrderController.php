<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $startTime     = microtime(true);
        $orders        = Order::all();
        $endTime       = microtime(true);
        $executionTime = $endTime - $startTime;
        return view('order.index', compact('orders','executionTime'));
    }

    public function optimizeQuery(){
        $startTime     = microtime(true);
        $orders        = Order::with(['user:id,name', 'product:id,name'])->latest()->paginate(50);
        $endTime       = microtime(true);
        $executionTime = $endTime - $startTime;
        return view('order.optimize-query', compact('orders','executionTime'));
    }
}
