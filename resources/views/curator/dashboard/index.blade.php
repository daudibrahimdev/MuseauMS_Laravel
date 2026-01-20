@extends('layouts.curator')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard Overview')

@section('content')
<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon"><i data-feather="dollar-sign"></i></div>
        <div class="card-info">
            <h3>IDR 250M</h3>
            <p>Total Sales</p>
        </div>
    </div>
    <div class="card">
        <div class="card-icon"><i data-feather="shopping-cart"></i></div>
        <div class="card-info">
            <h3>{{ $stats['total_orders'] }}</h3>
            <p>Total Orders</p>
        </div>
    </div>
    <div class="card">
        <div class="card-icon"><i data-feather="image"></i></div>
        <div class="card-info">
            <h3>{{ $stats['total_artworks'] }}</h3>
            <p>Artworks</p>
        </div>
    </div>
</div>

<div class="recent-grid">
    <div class="projects">
        <div class="card">
            <div class="card-header">
                <h3>Recent Orders</h3>
                <button>See all</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table width="100%">
                        <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Customer</td>
                                <td>Status</td>
                                <td>Amount</td>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Loop data order di sini nantinya --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="customers">
        <div class="card">
            <div class="card-header">
                <h3>Sales Analytics</h3>
                <button>Month</button>
            </div>
            <div class="card-body">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Paste kode Chart.js lu di sini
    const ctx = document.getElementById('salesChart').getContext('2d');
    // ... rest of chart code ...
</script>
@endpush