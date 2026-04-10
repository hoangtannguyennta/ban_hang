@extends('layouts.admin')

@section('page_title', 'Chỉnh sửa Danh mục')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Chỉnh sửa Danh mục: {{ $category->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label">Biểu tượng (Icon)</label>
                            <input type="file" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" accept="image/*">
                            @if($category->icon)
                                <div class="mt-2">
                                    <p class="small text-muted mb-1">Icon hiện tại:</p>
                                    <img src="{{ $category->icon }}" class="img-thumbnail" width="80">
                                </div>
                            @endif
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-save me-1"></i> Cập nhật danh mục
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection