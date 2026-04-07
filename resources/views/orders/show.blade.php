@extends('layouts.admin')

@section('page_title', 'Chi tiết Đơn hàng #' . $order->id)

@section('content')

<div class="row">
    <div class="col-md-8">
        <!-- Danh sách sản phẩm -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-list me-2"></i>Sản phẩm trong đơn hàng</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-end">Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product->images)
                                            <img src="{{ $item->product->images }}" alt="{{ $item->product->name }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fa-solid fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $item->product->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">{{ number_format($item->price) }} ₫</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end fw-bold">{{ number_format($item->price * $item->quantity) }} ₫</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                <td class="text-end text-primary fw-bold fs-5">{{ number_format($order->total_amount) }} ₫</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Cập nhật trạng thái (Update) -->
        <div class="card shadow-sm mb-4 border-primary">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="fa-solid fa-gears me-2"></i>Trạng thái đơn hàng</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label text-muted small">Cập nhật trạng thái mới</label>
                        <select name="status" class="form-select border-primary shadow-none">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang giao</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Lưu thay đổi
                    </button>
                </form>
            </div>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-user me-2"></i>Thông tin khách hàng</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="small text-muted d-block">Họ tên</label>
                    <span class="fw-bold">{{ $order->name }}</span>
                </div>
                <div class="mb-3">
                    <label class="small text-muted d-block">Số điện thoại</label>
                    <span class="fw-bold">{{ $order->phone_number }}</span>
                </div>
                <div class="mb-3">
                    <label class="small text-muted d-block">Địa chỉ giao hàng</label>
                    <span>{{ $order->shipping_address }}</span>
                </div>
                <div class="mb-0">
                    <label class="small text-muted d-block">Ngày đặt hàng</label>
                    <span>{{ $order->created_at->format('d/m/Y H:i:s') }}</span>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">
            <i class="fa-solid fa-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>
</div>
@endsection