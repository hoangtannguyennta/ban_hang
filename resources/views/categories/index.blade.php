@extends('layouts.admin')

@section('page_title', 'Quản lý Danh mục')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-layer-group me-2"></i>Danh sách Danh mục</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus me-1"></i> Thêm Danh mục mới
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th width="100">Icon</th>
                            <th>Tên danh mục</th>
                            <th>Ngày tạo</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    @if ($category->icon)
                                        <img src="{{ $category->icon }}" alt="{{ $category->name }}" class="rounded shadow-sm" width="40" height="40" style="object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width: 40px; height: 40px;">
                                            <i class="fa-solid fa-icons text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $category->name }}</div>
                                </td>
                                <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-outline-warning btn-sm me-1" title="Chỉnh sửa">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')" title="Xóa">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Chưa có danh mục nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection