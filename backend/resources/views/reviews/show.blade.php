@extends('layouts.admin')

@section('page_title', 'Chi tiết Đánh giá #' . $review->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Chi tiết Đánh giá #{{ $review->id }}</h1>
    <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Quay lại danh sách
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-star me-2"></i>Thông tin Đánh giá</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="small text-muted d-block">ID Đánh giá</label>
                <span class="fw-bold">{{ $review->id }}</span>
            </div>
            <div class="col-md-6">
                <label class="small text-muted d-block">Người đánh giá</label>
                <span class="fw-bold">{{ $review->user->name }} ({{ $review->user->email }})</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="small text-muted d-block">Sản phẩm</label>
                <span class="fw-bold">{{ $review->product->name }}</span>
            </div>
            <div class="col-md-6">
                <label class="small text-muted d-block">Rating</label>
                <span class="fw-bold">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review->rating)
                            <i class="fa-solid fa-star text-warning"></i>
                        @else
                            <i class="fa-regular fa-star text-warning"></i>
                        @endif
                    @endfor
                    ({{ $review->rating }}/5)
                </span>
            </div>
        </div>
        <div class="mb-3">
            <label class="small text-muted d-block">Bình luận</label>
            <span>{{ $review->comment ?? 'Không có bình luận.' }}</span>
        </div>
        <div class="mb-0">
            <label class="small text-muted d-block">Ngày tạo</label>
            <span>{{ $review->created_at->format('d/m/Y H:i:s') }}</span>
        </div>
    </div>
</div>

<a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-warning me-2">
    <i class="fa-solid fa-edit me-1"></i> Chỉnh sửa
</a>
<form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này không?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
        <i class="fa-solid fa-trash me-1"></i> Xóa
    </button>
</form>
@endsection