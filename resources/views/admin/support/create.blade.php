@extends('admin.layouts.app')
@section('title', 'Add Support Member')
@section('content')
<div class="content-card" style="max-width: 800px;">
    <h2 style="font-size: 24px; font-weight: 600; color: #2c3e50; margin-bottom: 24px;">Add Support Member</h2>
    <form action="{{ route('admin.support.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Password *</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Specialization</label>
            <input type="text" name="specialization" class="form-control" value="{{ old('specialization') }}" placeholder="e.g., Technical Support, Customer Service">
        </div>
        <div style="display: flex; gap: 12px; margin-top: 30px;">
            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Add Member</button>
            <a href="{{ route('admin.support.index') }}" class="btn-danger" style="text-decoration: none;"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
@endsection