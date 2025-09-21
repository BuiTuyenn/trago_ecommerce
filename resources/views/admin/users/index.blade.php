@extends('layouts.admin')

@section('title', 'Quản lý người dùng')
@section('page-title', 'Quản lý người dùng')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    Danh sách người dùng
                </h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên hiển thị</th>
                                <th>Email</th>
                                <th>Quyền</th>
                                <th>Trạng thái</th>
                                <th>Đăng nhập cuối</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $user->full_name ?? $user->name }}</h6>
                                                @if($user->first_name && $user->last_name)
                                                    <small class="text-muted">{{ $user->name }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role === 'admin')
                                            <span class="badge bg-danger">Admin</span>
                                        @else
                                            <span class="badge bg-primary">Customer</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-secondary">Đã khóa</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->last_login_at)
                                            {{ $user->last_login_at->format('d/m/Y H:i') }}
                                        @else
                                            <span class="text-muted">Chưa đăng nhập</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($user->id !== Auth::id())
                                                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-{{ $user->is_active ? 'warning' : 'success' }}" 
                                                            onclick="return confirm('Bạn có chắc muốn {{ $user->is_active ? 'khóa' : 'kích hoạt' }} tài khoản này?')">
                                                        <i class="fas fa-{{ $user->is_active ? 'lock' : 'unlock' }}"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-users fa-2x text-muted mb-2"></i>
                                        <p class="text-muted">Chưa có người dùng nào</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
</style>
@endpush
