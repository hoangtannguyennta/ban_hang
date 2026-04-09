@extends('layouts.admin')

@section('page_title', 'Chỉnh sửa mã QR')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa cấu hình QR</h1>
    <a href="{{ route('admin.qr_codes.index') }}" class="btn btn-link text-decoration-none">
        <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.qr_codes.update', $qrCode->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="bank_name" class="form-label fw-bold">Tên ngân hàng</label>
                        <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" value="{{ old('bank_name', $qrCode->bank_name) }}" required>
                        @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="account_number" class="form-label fw-bold">Số tài khoản</label>
                        <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number', $qrCode->account_number) }}" required>
                        @error('account_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="account_owner" class="form-label fw-bold">Họ tên chủ tài khoản</label>
                        <input type="text" class="form-control @error('account_owner') is-invalid @enderror" id="account_owner" name="account_owner" value="{{ old('account_owner', $qrCode->account_owner) }}" style="text-transform: uppercase;" required>
                        @error('account_owner') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label fw-bold">Thay đổi ảnh mã QR</label>
                        <div class="mb-2">
                            <img id="image-preview" src="{{ $qrCode->images ?: '#' }}" alt="QR Preview" 
                                 style="max-height: 150px; {{ $qrCode->images ? '' : 'display: none;' }}" 
                                 class="border rounded p-1">
                        </div>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images" accept="image/*">
                        @error('images') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch p-0 ps-5">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input ms-n5" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $qrCode->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">Kích hoạt làm cổng chính</label>
                            <p class="text-muted small">Lưu ý: Khi bật, hệ thống sẽ tự động tắt mã đang hoạt động trước đó.</p>
                        </div>
                    </div>

                    <hr class="my-4">
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="fa-solid fa-save me-1"></i> Cập nhật thay đổi
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