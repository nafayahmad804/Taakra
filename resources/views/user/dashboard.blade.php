@extends('layouts.user')

@section('title', 'My Dashboard')

@section('content')
<div style="max-width: 1400px; margin: 0 auto;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 48px; color: white; margin-bottom: 40px; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50%; right: -10%; width: 600px; height: 600px; background: rgba(255,255,255,0.05); border-radius: 50%; filter: blur(80px);"></div>
        <div style="position: relative; z-index: 1;">
            <h1 style="font-size: 42px; font-weight: 800; margin-bottom: 16px;">Welcome back, {{ auth()->user()->name }}! 🎉</h1>
            <p style="font-size: 18px; opacity: 0.9;">Ready to join your next competition?</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-left: 4px solid #4A90E2;">
            <div style="font-size: 14px; color: #6c757d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Total Registrations</div>
            <div style="font-size: 48px; font-weight: 800; color: #4A90E2; margin-bottom: 8px;">{{ $stats['total_registrations'] }}</div>
            <div style="font-size: 13px; color: #95a5a6;">All time competitions</div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-left: 4px solid #27ae60;">
            <div style="font-size: 14px; color: #6c757d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Confirmed</div>
            <div style="font-size: 48px; font-weight: 800; color: #27ae60; margin-bottom: 8px;">{{ $stats['confirmed'] }}</div>
            <div style="font-size: 13px; color: #95a5a6;">Ready to participate</div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-left: 4px solid #f39c12;">
            <div style="font-size: 14px; color: #6c757d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Pending</div>
            <div style="font-size: 48px; font-weight: 800; color: #f39c12; margin-bottom: 8px;">{{ $stats['pending'] }}</div>
            <div style="font-size: 13px; color: #95a5a6;">Awaiting approval</div>
        </div>
    </div>

    <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
            <h2 style="font-size: 28px; font-weight: 700; color: #2c3e50;">My Recent Registrations</h2>
            <a href="{{ route('competitions.my') }}" style="color: #4A90E2; text-decoration: none; font-weight: 600; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        @forelse($registrations as $registration)
        <div style="border-bottom: 1px solid #e9ecef; padding: 20px 0; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
            <div style="flex: 1;">
                <h3 style="font-size: 18px; font-weight: 600; color: #2c3e50; margin-bottom: 8px;">{{ $registration->competition->title }}</h3>
                <div style="display: flex; gap: 16px; align-items: center;">
                    <span style="font-size: 13px; color: #6c757d; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-folder"></i> {{ $registration->competition->category->name }}
                    </span>
                    <span style="font-size: 13px; color: #6c757d; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-calendar"></i> {{ $registration->created_at->format('M d, Y') }}
                    </span>
                </div>
            </div>
            <div>
                <span class="badge 
                    @if($registration->status === 'pending') badge-warning
                    @elseif($registration->status === 'confirmed') badge-success
                    @else badge-danger
                    @endif">
                    {{ ucfirst($registration->status) }}
                </span>
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 60px 20px;">
            <i class="fas fa-trophy" style="font-size: 64px; color: #e9ecef; margin-bottom: 20px;"></i>
            <p style="font-size: 18px; color: #6c757d; margin-bottom: 24px;">You haven't registered for any competitions yet</p>
            <a href="{{ route('competitions.index') }}" class="btn-primary">Browse Competitions</a>
        </div>
        @endforelse
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 16px; padding: 40px; color: white; position: relative; overflow: hidden;">
            <div style="position: absolute; bottom: -30px; right: -30px; font-size: 120px; opacity: 0.1;"><i class="fas fa-search"></i></div>
            <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 12px;">Explore Competitions</h3>
            <p style="opacity: 0.9; margin-bottom: 24px;">Discover exciting competitions in various categories</p>
            <a href="{{ route('competitions.index') }}" style="background: white; color: #4facfe; padding: 12px 28px; border-radius: 8px; text-decoration: none; display: inline-block; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                Browse Now
            </a>
        </div>

        <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 16px; padding: 40px; color: white; position: relative; overflow: hidden;">
            <div style="position: absolute; bottom: -30px; right: -30px; font-size: 120px; opacity: 0.1;"><i class="fas fa-headset"></i></div>
            <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 12px;">Need Help?</h3>
            <p style="opacity: 0.9; margin-bottom: 24px;">Chat with our support team or AI assistant</p>
            <button onclick="openChat()" style="background: white; color: #fa709a; padding: 12px 28px; border-radius: 8px; text-decoration: none; display: inline-block; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                Start Chat
            </button>
        </div>
    </div>
</div>
@endsection