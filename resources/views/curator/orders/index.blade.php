@extends('layouts.curator')

@section('title', 'Orders Management')
@section('header_title', 'Orders Management')

@section('content')
<div class="recent-grid" style="display: block;">
    <div class="projects">
        <div class="card">
            <div class="card-header">
                <h3>All Orders</h3>
                
                <div class="filter-group">
                    <form action="{{ route('curator.orders.index') }}" method="GET" style="display: flex; gap: 10px;">
                        <select name="status" onchange="this.form.submit()" style="background: #1a1a1a; color: #fff; border: 1px solid #b6895b; padding: 5px 10px; border-radius: 5px; cursor: pointer;">
                            <option value="">All Orders</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Needs Confirmation</option>
                            <option value="delivery" {{ request('status') == 'delivery' ? 'selected' : '' }}>Processing/Delivery</option>
                            <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>In Shipping</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table width="100%">
                        <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Customer</td>
                                <td>Amount</td>
                                <td>Payment</td>
                                <td>Shipment</td>
                                <td style="text-align: center;">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                {{-- Menampilkan Nomor Order sesuai Class Diagram --}}
                                <td>#{{ $order->order_number }}</td>
                                
                                {{-- Menampilkan Data User (Inheritance dari class User) --}}
                                <td>
                                    <div class="client">
                                        <div class="client-info">
                                            <h4>{{ $order->user->name }}</h4>
                                            <small>{{ $order->user->email }}</small>
                                        </div>
                                    </div>
                                </td>

                                {{-- Format Mata Uang IDR yang Profesional --}}
                                <td>IDR {{ number_format($order->total_price, 0, ',', '.') }}</td>

                                {{-- Status Pembayaran (verifyPayment() Target) --}}
                                <td>
                                    <span class="status {{ $order->payment_status }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>

                                {{-- Status Pengiriman (Relationship Has One Shipment) --}}
                                <td>
                                    <span class="status {{ $order->shipment->status ?? 'none' }}">
                                        {{ ucfirst($order->shipment->status ?? 'Not Processed') }}
                                    </span>
                                </td>

                                {{-- Link Action ke Halaman Show Detail --}}
                                <td style="text-align: center;">
                                    <a href="{{ route('curator.orders.show', $order->id) }}" 
                                       style="background: transparent; border: none; color: #b6895b; text-decoration: none; display: inline-block;">
                                        <i data-feather="eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 3rem; color: #888;">
                                    <i data-feather="info" style="margin-bottom: 10px;"></i>
                                    <p>No orders found matching the filter.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination dengan Query String Filter tetap terjaga --}}
                <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection