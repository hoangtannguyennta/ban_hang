@extends('layouts.admin')

@section('page_title', 'Thêm mã QR mới')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm cấu hình QR mới</h1>
    <a href="{{ route('admin.qr_codes.index') }}" class="btn btn-link text-decoration-none">
        <i class="fa-solid fa-arrow-left me-1"></i> Quay lại danh sách
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.qr_codes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="bank_name" class="form-label fw-bold">Tên ngân hàng (hoặc Mã ngân hàng)</label>
                        <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" value="{{ old('bank_name') }}" placeholder="Ví dụ: VCB, MB, VietinBank..." required>
                        <div class="form-text">Mã này sẽ dùng để tạo link VietQR tự động.</div>
                        @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="account_number" class="form-label fw-bold">Số tài khoản</label>
                        <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number') }}" required>
                        @error('account_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="account_owner" class="form-label fw-bold">Họ tên chủ tài khoản</label>
                        <input type="text" class="form-control @error('account_owner') is-invalid @enderror" id="account_owner" name="account_owner" value="{{ old('account_owner') }}" style="text-transform: uppercase;" required>
                        @error('account_owner') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label fw-bold">Ảnh mã QR (Tùy chọn)</label>
                        <div class="mb-2">
                            <img id="image-preview" src="#" alt="Preview" style="max-height: 150px; display: none;" class="border rounded p-1">
                        </div>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images" accept="image/*">
                        <div class="form-text">Nếu để trống, hệ thống sẽ sử dụng VietQR tự động dựa trên STK.</div>
                        @error('images') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch p-0 ps-5">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input ms-n5" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">Kích hoạt làm cổng chính</label>
                            <p class="text-muted small">Lưu ý: Chỉ một mã QR được phép kích hoạt tại một thời điểm. Kích hoạt mã này sẽ tự động tắt các mã khác.</p>
                        </div>
                    </div>

                    <hr class="my-4">
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="fa-solid fa-save me-1"></i> Lưu cấu hình QR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('images').onchange = evt => {
        const [file] = document.getElementById('images').files
        if (file) {
            const preview = document.getElementById('image-preview');
            if (preview) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        }
    }
</script>
@endsection