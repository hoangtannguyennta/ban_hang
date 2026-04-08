@extends('layouts.admin')
@section('page_title', 'Quản lý Đơn hàng')
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-cart-shopping me-2"></i>Danh sách Đơn hàng</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Kích cỡ</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>
                            <div class="fw-bold">{{ $order?->user?->name }}</div>
                            <small class="text-muted">{{ $order->phone_number }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $order->items->pluck('size')->filter()->unique()->implode(', ') ?: 'N/A' }}</span>
                        </td>
                        <td class="text-primary fw-bold">{{ number_format($order->total_amount) }} ₫</td>
                        <td>
                            @php
                                $statusBadge = [
                                    'pending' => 'bg-warning text-dark',
                                    'processing' => 'bg-info text-white',
                                    'completed' => 'bg-success text-white',
                                    'cancelled' => 'bg-danger text-white'
                                ];
                                $statusText = [
                                    'pending' => 'Chờ xử lý',
                                    'processing' => 'Đang giao',
                                    'completed' => 'Hoàn thành',
                                    'cancelled' => 'Đã hủy'
                                ];
                            @endphp
                            <span class="badge {{ $statusBadge[$order->status] ?? 'bg-secondary' }}">
                                {{ $statusText[$order->status] ?? $order->status }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fa-solid fa-eye"></i> Chi tiết
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Không có đơn hàng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    </div>
</div>
@endsection