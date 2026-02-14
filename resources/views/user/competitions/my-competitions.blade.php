@extends('layouts.user')
@section('title', 'My Competitions')
@section('content')
<div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 32px;">
    <h1 style="font-size: 36px; font-weight: 800; color: #2c3e50; margin-bottom: 12px;">My Competitions</h1>
    <p style="font-size: 16px; color: #6c757d;">Track all your registered competitions in one place</p>
</div>

@if($registrations->count() > 0)
<div style="display: grid; gap: 24px;">
    @foreach($registrations as $registration)
    <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); display: flex; gap: 32px; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,0.12)'" onmouseout="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'">
        <div style="flex: 1;">
            <div style="margin-bottom: 12px;">
                <span style="background: #e3f2fd; color: #1976d2; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-right: 12px;">
                    {{ $registration->competition->category->name }}
                </span>
                <span class="badge 
                    @if($registration->status === 'pending') badge-warning
                    @elseif($registration->status === 'confirmed') badge-success
                    @else badge-danger
                    @endif">
                    {{ ucfirst($registration->status) }}
                </span>
            </div>
            
            <h2 style="font-size: 28px; font-weight: 700; color: #2c3e50; margin-bottom: 16px;">{{ $registration->competition->title }}</h2>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                <div>
                    <div style="font-size: 12px; color: #6c757d; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Registered On</div>
                    <div style="font-size: 15px; font-weight: 600; color: #2c3e50;">{{ $registration->created_at->format('M d, Y') }}</div>
                </div>
                <div>
                    <div style="font-size: 12px; color: #6c757d; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Starts</div>
                    <div style="font-size: 15px; font-weight: 600; color: #2c3e50;">{{ $registration->competition->start_date->format('M d, Y') }}</div>
                </div>
                <div>
                    <div style="font-size: 12px; color: #6c757d; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Ends</div>
                    <div style="font-size: 15px; font-weight: 600; color: #2c3e50;">{{ $registration->competition->end_date->format('M d, Y') }}</div>
                </div>
            </div>
            
            <a href="{{ route('competitions.show', $registration->competition->slug) }}" style="color: #4A90E2; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                View Competition Details <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        @if($registration->competition->image)
        <div style="width: 200px; height: 200px; border-radius: 12px; overflow: hidden; flex-shrink: 0;">
            <img src="{{ asset('storage/' . $registration->competition->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        @endif
    </div>
    @endforeach
</div>

<div style="margin-top: 32px;">
    {{ $registrations->links() }}
</div>
@else
<div style="background: white; border-radius: 16px; padding: 80px 40px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
    <i class="fas fa-trophy" style="font-size: 80px; color: #e9ecef; margin-bottom: 24px;"></i>
    <h2 style="font-size: 28px; font-weight: 700; color: #2c3e50; margin-bottom: 16px;">No competitions yet</h2>
    <p style="font-size: 16px; color: #6c757d; margin-bottom: 32px;">Start your competitive journey by registering for a competition</p>
    <a href="{{ route('competitions.index') }}" class="btn-primary">Browse Competitions</a>
</div>
@endif
@endsection