@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 30px;">
    <div class="content-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 8px;">Total Users</p>
                <h2 style="font-size: 36px; font-weight: 700;">{{ $stats['total_users'] }}</h2>
            </div>
            <i class="fas fa-users" style="font-size: 48px; opacity: 0.3;"></i>
        </div>
    </div>

    <div class="content-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 8px;">Total Competitions</p>
                <h2 style="font-size: 36px; font-weight: 700;">{{ $stats['total_competitions'] }}</h2>
            </div>
            <i class="fas fa-trophy" style="font-size: 48px; opacity: 0.3;"></i>
        </div>
    </div>

    <div class="content-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 8px;">Total Registrations</p>
                <h2 style="font-size: 36px; font-weight: 700;">{{ $stats['total_registrations'] }}</h2>
            </div>
            <i class="fas fa-user-check" style="font-size: 48px; opacity: 0.3;"></i>
        </div>
    </div>

    <div class="content-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 8px;">Pending Registrations</p>
                <h2 style="font-size: 36px; font-weight: 700;">{{ $stats['pending_registrations'] }}</h2>
            </div>
            <i class="fas fa-clock" style="font-size: 48px; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 30px;">
    <div class="content-card">
        <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; color: #2c3e50;">Top Competitions by Registrations</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Competition</th>
                    <th>Category</th>
                    <th>Registrations</th>
                </tr>
            </thead>
            <tbody>
                @forelse($top_competitions as $competition)
                <tr>
                    <td>{{ $competition->title }}</td>
                    <td>{{ $competition->category->name }}</td>
                    <td><span class="badge badge-success">{{ $competition->confirmed_registrations_count }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #95a5a6;">No competitions yet</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="content-card">
        <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; color: #2c3e50;">Recent Registrations</h3>
        <div style="max-height: 400px; overflow-y: auto;">
            @forelse($recent_registrations as $registration)
            <div style="padding: 12px; border-bottom: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="font-weight: 600; margin-bottom: 4px;">{{ $registration->user->name }}</p>
                    <p style="font-size: 13px; color: #6c757d;">{{ $registration->competition->title }}</p>
                </div>
                <span class="badge 
                    @if($registration->status === 'pending') badge-warning
                    @elseif($registration->status === 'confirmed') badge-success
                    @else badge-danger
                    @endif">
                    {{ ucfirst($registration->status) }}
                </span>
            </div>
            @empty
            <p style="text-align: center; color: #95a5a6; padding: 20px;">No registrations yet</p>
            @endforelse
        </div>
    </div>
</div>

<div class="content-card">
    <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 16px; color: #2c3e50;">Quick Stats</h3>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
            <p style="color: #6c757d; margin-bottom: 8px;">Active Competitions</p>
            <h3 style="font-size: 32px; font-weight: 700; color: #4A90E2;">{{ $stats['active_competitions'] }}</h3>
        </div>
        <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
            <p style="color: #6c757d; margin-bottom: 8px;">Total Categories</p>
            <h3 style="font-size: 32px; font-weight: 700; color: #4A90E2;">{{ $stats['total_categories'] }}</h3>
        </div>
        <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
            <p style="color: #6c757d; margin-bottom: 8px;">Avg. Registrations</p>
            <h3 style="font-size: 32px; font-weight: 700; color: #4A90E2;">
                {{ $stats['total_competitions'] > 0 ? round($stats['total_registrations'] / $stats['total_competitions'], 1) : 0 }}
            </h3>
        </div>
    </div>
</div>
@endsection