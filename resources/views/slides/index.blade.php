@extends('layouts.admin')

@section('page_title', 'Quản lý Slide')

@section('content')

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-image me-2"></i>Danh sách Slide</h5>
            <a href="{{ route('admin.slides.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus me-1"></i> Thêm Slide mới
            </a>
        </div>
    </div>

    </section>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="100">Thứ tự</th>
                        <th width="150">Hình ảnh</th>
                        <th>Tiêu đề / Mô tả</th>
                        <th>Liên kết</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($slides as $slide)
                        <tr>
                            <td>{{ $slide->order }}</td>
                            <td>
                                <img src="{{ $slide->images }}" alt="{{ $slide->title }}"
                                    class="img-thumbnail" style="height: 80px; width: 120px; object-fit: cover">
                            </td>
                            <td>
                                <div class="fw-bold">{{ $slide->title }}</div>
                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($slide->desc, 50) }}</small>
                            </td>
                            <td><a href="{{ $slide->link }}"
                                    target="_blank">{{ \Illuminate\Support\Str::limit($slide->link, 30) }}</a></td>
                            <td>
                                <span
                                    class="badge {{ $slide->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                    {{ $slide->is_active ? 'Đang hiển thị' : 'Đang ẩn' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.slides.edit', $slide->id) }}"
                                    class="btn btn-outline-warning btn-sm me-1" title="Chỉnh sửa">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.slides.destroy', $slide->id) }}" method="POST"
                                    class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa slide này?')" title="Xóa">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Chưa có slide nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
