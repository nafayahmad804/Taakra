@extends('admin.layouts.app')

@section('title', 'Competitions')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 600; color: #2c3e50;">All Competitions</h2>
        <a href="{{ route('admin.competitions.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Add Competition
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Registrations</th>
                <th>Deadline</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($competitions as $competition)
            <tr>
                <td>
                    <strong>{{ $competition->title }}</strong>
                    @if($competition->image)
                    <br><small style="color: #6c757d;">Has image</small>
                    @endif
                </td>
                <td>{{ $competition->category->name }}</td>
                <td>
                    <span class="badge 
                        @if($competition->status === 'published') badge-success
                        @elseif($competition->status === 'draft') badge-warning
                        @elseif($competition->status === 'ongoing') badge-info
                        @else badge-danger
                        @endif">
                        {{ ucfirst($competition->status) }}
                    </span>
                </td>
                <td><span class="badge badge-info">{{ $competition->confirmed_registrations_count }}</span></td>
                <td>{{ $competition->registration_deadline->format('M d, Y') }}</td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.competitions.edit', $competition) }}" class="btn-warning" style="text-decoration: none; font-size: 12px;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form id="delete-form-{{ $competition->id }}" action="{{ route('admin.competitions.destroy', $competition) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('delete-form-{{ $competition->id }}')" class="btn-danger" style="font-size: 12px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: #95a5a6;">
                    No competitions found. <a href="{{ route('admin.competitions.create') }}" style="color: #4A90E2;">Create one</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 24px;">
        {{ $competitions->links() }}
    </div>
</div>
@endsection