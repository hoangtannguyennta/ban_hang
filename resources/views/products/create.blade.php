@extends('layouts.admin')

@section('page_title', 'Thêm Sản phẩm mới')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fa-solid fa-plus-circle me-2"></i>Thêm Sản phẩm mới</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Tên sản phẩm</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="Nhập tên sản phẩm..." required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-semibold">Danh mục</label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Mô tả sản phẩm</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4" placeholder="Mô tả chi tiết về sản phẩm...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sizes" class="form-label fw-semibold">Kích cỡ (Sizes)</label>
                            <input type="text" class="form-control @error('sizes') is-invalid @enderror" name="sizes" id="sizes" value="{{ old('sizes') }}" placeholder="Ví dụ: S, M, L hoặc 38, 39, 40...">
                            <div class="form-text">Nhập các kích cỡ cách nhau bằng dấu phẩy.</div>
                            @error('sizes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-semibold">Giá bán (VNĐ)</label>
                                <div class="input-group">
                                    <input type="text" 
                                        class="form-control @error('price') is-invalid @enderror" 
                                        name="price" 
                                        id="price" 
                                        value="{{ old('price') ? number_format((float)str_replace('.', '', old('price')), 0, ',', '.') : '' }}" 
                                        placeholder="Ví dụ: 1.000.000" 
                                        required>
                                    <span class="input-group-text">₫</span>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label fw-semibold">Số lượng tồn kho</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock" value="{{ old('stock', 0) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="images" class="form-label fw-semibold">Hình ảnh minh họa</label>
                            <input type="file" class="form-control @error('images') is-invalid @enderror" name="images" id="images" onchange="previewImage(this)">
                            <div class="form-text">Định dạng hỗ trợ: JPG, PNG, WEBP.</div>
                            <div id="image-preview-container" class="mt-3 d-none">
                                <img id="image-preview" src="#" alt="Preview" class="img-thumbnail" width="200">
                            </div>
                            @error('images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-4">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4">Hủy</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa-solid fa-save me-1"></i> Lưu sản phẩm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('image-preview-container');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            container.classList.add('d-none');
        }
    }

    // Tự động định dạng dấu chấm phân cách hàng ngàn khi người dùng nhập giá
    const priceInput = document.getElementById('price');
    if (priceInput) {
        priceInput.addEventListener('input', function(e) {
            // Loại bỏ tất cả ký tự không phải số
            let value = e.target.value.replace(/\D/g, "");
            // Thêm dấu chấm phân cách hàng ngàn
            e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });
    }
</script>
@endpush