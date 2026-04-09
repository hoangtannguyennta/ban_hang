@extends('layouts.admin')

@section('page_title', 'Quản lý QR Code')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Cấu hình mã QR thanh toán</h1>
    <a href="{{ route('admin.qr_codes.create') }}" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-plus me-1"></i> Thêm mã QR mới
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Hình ảnh</th>
                        <th>Ngân hàng</th>
                        <th>Số tài khoản</th>
                        <th>Chủ tài khoản</th>
                        <th>Trạng thái</th>
                        <th class="text-end pe-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($qrCodes as $qr)
                        <tr>
                            <td class="ps-4">{{ $qr->id }}</td>
                            <td>
                                @if($qr->images)
                                    <img src="{{ $qr->images }}" alt="QR" style="height: 40px; width: 40px; object-fit: cover;" class="rounded border">
                                @else
                                    <span class="badge bg-light text-muted border small">Tự động</span>
                                @endif
                            </td>
                            <td class="fw-bold text-primary">{{ $qr->bank_name }}</td>
                            <td><code>{{ $qr->account_number }}</code></td>
                            <td class="text-uppercase">{{ $qr->account_owner }}</td>
                            <td>
                                @if($qr->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3">Đang dùng</span>
                                @else
                                    <span class="badge bg-light text-muted border px-3">Tắt</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('admin.qr_codes.edit', $qr->id) }}" class="btn btn-outline-warning btn-sm" title="Chỉnh sửa">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.qr_codes.destroy', $qr->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa cấu hình này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Xóa">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-qrcode d-block mb-2 fs-1 opacity-25"></i>
                                Chưa có cấu hình mã QR nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $qrCodes->links() }}
    </div>
</div>
@endsection