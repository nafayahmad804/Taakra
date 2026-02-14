@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 600; color: #2c3e50;">All Categories</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Add Category
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Competitions</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        @if($category->icon)
                        <i class="{{ $category->icon }}" style="color: #4A90E2;"></i>
                        @endif
                        <strong>{{ $category->name }}</strong>
                    </div>
                </td>
                <td>{{ $category->slug }}</td>
                <td><span class="badge badge-info">{{ $category->competitions_count }}</span></td>
                <td>
                    <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>{{ $category->created_at->format('M d, Y') }}</td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn-warning" style="text-decoration: none; font-size: 12px;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('delete-form-{{ $category->id }}')" class="btn-danger" style="font-size: 12px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: #95a5a6;">
                    No categories found. <a href="{{ route('admin.categories.create') }}" style="color: #4A90E2;">Create one</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 24px;">
        {{ $categories->links() }}
    </div>
</div>
@endsection