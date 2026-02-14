@extends('admin.layouts.app')
@section('title', 'Support Team')
@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 600; color: #2c3e50;">Support Team Members</h2>
        <a href="{{ route('admin.support.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Add Support Member</a>
    </div>
    <table class="table">
        <thead>
            <tr><th>Name</th><th>Email</th><th>Specialization</th><th>Status</th><th>Added</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($supportMembers as $member)
            <tr>
                <td><strong>{{ $member->user->name }}</strong></td>
                <td>{{ $member->user->email }}</td>
                <td>{{ $member->specialization ?? 'N/A' }}</td>
                <td><span class="badge {{ $member->is_active ? 'badge-success' : 'badge-danger' }}">{{ $member->is_active ? 'Active' : 'Inactive' }}</span></td>
                <td>{{ $member->created_at->format('M d, Y') }}</td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.support.edit', $member) }}" class="btn-warning" style="text-decoration: none; font-size: 12px;"><i class="fas fa-edit"></i></a>
                        <form id="delete-support-{{ $member->id }}" action="{{ route('admin.support.destroy', $member) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('delete-support-{{ $member->id }}')" class="btn-danger" style="font-size: 12px;"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align: center; padding: 40px; color: #95a5a6;">No support members found. <a href="{{ route('admin.support.create') }}" style="color: #4A90E2;">Add one</a></td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top: 24px;">{{ $supportMembers->links() }}</div>
</div>
@endsection