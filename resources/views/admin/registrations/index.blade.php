
@extends('admin.layouts.app')
@section('title', 'Registrations')
@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 600; color: #2c3e50;">All Registrations</h2>
        <div>
            <select onchange="window.location.href='?status=' + this.value" class="form-control" style="width: auto; display: inline-block;">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Competition</th>
                <th>Status</th>
                <th>Registered At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $registration)
            <tr>
                <td><strong>{{ $registration->user->name }}</strong><br><small>{{ $registration->user->email }}</small></td>
                <td>{{ $registration->competition->title }}</td>
                <td>
                    <span class="badge 
                        @if($registration->status === 'pending') badge-warning
                        @elseif($registration->status === 'confirmed') badge-success
                        @else badge-danger
                        @endif">
                        {{ ucfirst($registration->status) }}
                    </span>
                </td>
                <td>{{ $registration->created_at->format('M d, Y H:i') }}</td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        @if($registration->status === 'pending')
                        <form action="{{ route('admin.registrations.confirm', $registration) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-success" style="font-size: 12px;"><i class="fas fa-check"></i></button>
                        </form>
                        <form action="{{ route('admin.registrations.reject', $registration) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-warning" style="font-size: 12px;"><i class="fas fa-times"></i></button>
                        </form>
                        @endif
                        <form id="delete-reg-{{ $registration->id }}" action="{{ route('admin.registrations.destroy', $registration) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('delete-reg-{{ $registration->id }}')" class="btn-danger" style="font-size: 12px;"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align: center; padding: 40px; color: #95a5a6;">No registrations found</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top: 24px;">{{ $registrations->links() }}</div>
</div>
@endsection