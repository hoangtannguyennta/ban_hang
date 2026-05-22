@extends('layouts.admin')

@section('page_title', 'Sửa Sản phẩm')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-warning"><i class="fa-solid fa-pen-to-square me-2"></i>Sửa Sản phẩm: {{ $product->name }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Tên sản phẩm</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-semibold">Danh mục</label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Mô tả sản phẩm</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sizes" class="form-label fw-semibold">Kích cỡ (Sizes)</label>
                            <input type="text" class="form-control @error('sizes') is-invalid @enderror" name="sizes" id="sizes" value="{{ old('sizes', is_array($product->sizes) ? implode(', ', $product->sizes) : '') }}" placeholder="Ví dụ: S, M, L hoặc 38, 39, 40...">
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
                                        value="{{ old('price', $product->price ? number_format($product->price, 0, ',', '.') : '') }}" 
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
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="images" class="form-label fw-semibold">Hình ảnh sản phẩm</label>
                            <div class="mb-3" id="current-image-container">
                                @if ($product->images)
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ $product->images }}" alt="{{ $product->name }}" class="img-thumbnail" width="150">
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info text-dark">Hiện tại</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div id="new-image-preview-container" class="mb-3 d-none">
                                <div class="position-relative d-inline-block">
                                    <img id="new-image-preview" src="#" alt="New Preview" class="img-thumbnail" width="150">
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success text-white">Mới</span>
                                </div>
                            </div>

                            <input type="file" class="form-control @error('images') is-invalid @enderror" name="images" id="images" onchange="previewNewImage(this)">
                            <div class="form-text text-muted">Chọn file mới nếu bạn muốn thay đổi hình ảnh.</div>
                            @error('images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-4">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4">Hủy</a>
                            <button type="submit" class="btn btn-warning px-4 fw-semibold text-white">
                                <i class="fa-solid fa-rotate me-1"></i> Cập nhật ngay
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
    function previewNewImage(input) {
        const preview = document.getElementById('new-image-preview');
        const container = document.getElementById('new-image-preview-container');
        const currentContainer = document.getElementById('current-image-container');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
                if (currentContainer) currentContainer.style.opacity = '0.5';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            container.classList.add('d-none');
            if (currentContainer) currentContainer.style.opacity = '1';
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