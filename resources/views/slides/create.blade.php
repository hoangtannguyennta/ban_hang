@extends('layouts.admin')

@section('page_title', 'Thêm Slide mới')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-plus me-2"></i>Thêm Slide mới</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Tiêu đề (Title)</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="subtitle" class="form-label">Phụ đề (Subtitle)</label>
                        <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle') }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="desc" class="form-label">Mô tả ngắn</label>
                        <textarea class="form-control @error('desc') is-invalid @enderror" id="desc" name="desc" rows="3">{{ old('desc') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="link" class="form-label">Đường dẫn liên kết (URL)</label>
                        <input type="url" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link') }}" placeholder="https://...">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="order" class="form-label">Thứ tự hiển thị</label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', 0) }}">
                    </div>

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Hiển thị ngay</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="images" class="form-label">Chọn hình ảnh (Có thể chọn nhiều)</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple required accept="image/*">
                        <div id="image-preview-container" class="mt-3 d-flex flex-wrap gap-2"></div>
                        <div class="form-text text-muted">Mỗi tấm ảnh được chọn sẽ tạo thành một Slide riêng biệt với cùng nội dung trên.</div>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.slides.index') }}" class="btn btn-outline-secondary me-2">Hủy</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-1"></i> Lưu Slides
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#images').on('change', function() {
            const container = $('#image-preview-container');
            container.empty();
            const files = this.files;
            if (files) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('<img>').attr('src', e.target.result).addClass('img-thumbnail').css({'max-height': '150px', 'object-fit': 'cover'}).appendTo(container);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });
    });
</script>
@endpush
