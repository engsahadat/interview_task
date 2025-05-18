@extends('layouts.app')
@section('title', 'Order')
@section('content')
<div class="card">
    <div class="card-header">
        <h4>Orders</h4>
        <p>Execution Time: {{ $executionTime }} seconds</p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('Sl') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $sl => $order)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $order->user?->name }}</td>
                            <td>{{ $order->product?->name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>${{ number_format($order->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection