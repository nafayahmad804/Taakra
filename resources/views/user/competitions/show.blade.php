@extends('layouts.user')
@section('title', $competition->title)
@section('content')
<div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 40px;">
    @if($competition->image)
    <div style="height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative;">
        <img src="{{ asset('storage/' . $competition->image) }}" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9;">
        <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);"></div>
        <div style="position: absolute; bottom: 40px; left: 40px; right: 40px; color: white;">
            <span style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 16px;">
                {{ $competition->category->name }}
            </span>
            <h1 style="font-size: 48px; font-weight: 800; margin-bottom: 12px; text-shadow: 0 4px 12px rgba(0,0,0,0.3);">{{ $competition->title }}</h1>
            <div style="display: flex; gap: 24px; align-items: center;">
                <span style="display: flex; align-items: center; gap: 8px; font-size: 15px;">
                    <i class="fas fa-eye"></i> {{ $competition->views }} views
                </span>
                <span style="display: flex; align-items: center; gap: 8px; font-size: 15px;">
                    <i class="fas fa-users"></i> {{ $registrationCount }} registered
                </span>
            </div>
        </div>
    </div>
    @endif
    
    <div style="padding: 40px;">
        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 40px;">
            <div>
                <h2 style="font-size: 24px; font-weight: 700; color: #2c3e50; margin-bottom: 20px;">About This Competition</h2>
                <p style="font-size: 16px; line-height: 1.8; color: #495057; margin-bottom: 32px;">{{ $competition->description }}</p>
                
                @if($competition->rules)
                <h3 style="font-size: 20px; font-weight: 700; color: #2c3e50; margin-bottom: 16px; margin-top: 32px;">Rules & Guidelines</h3>
                <div style="background: #f8f9fa; padding: 24px; border-radius: 12px; border-left: 4px solid #4A90E2;">
                    <p style="font-size: 15px; line-height: 1.8; color: #495057; white-space: pre-line;">{{ $competition->rules }}</p>
                </div>
                @endif
                
                @if($competition->prizes)
                <h3 style="font-size: 20px; font-weight: 700; color: #2c3e50; margin-bottom: 16px; margin-top: 32px;">Prizes & Rewards</h3>
                <div style="background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%); padding: 24px; border-radius: 12px;">
                    <p style="font-size: 15px; line-height: 1.8; color: #2c3e50; white-space: pre-line;">{{ $competition->prizes }}</p>
                </div>
                @endif
            </div>
            
            <aside>
                <div style="background: #f8f9fa; border-radius: 16px; padding: 32px; position: sticky; top: 120px;">
                    <h3 style="font-size: 20px; font-weight: 700; color: #2c3e50; margin-bottom: 24px;">Competition Details</h3>
                    
                    <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #dee2e6;">
                        <div style="font-size: 13px; color: #6c757d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Entry Fee</div>
                        <div style="font-size: 28px; font-weight: 800; color: #4A90E2;">{{ $competition->entry_fee > 0 ? '$' . number_format($competition->entry_fee, 2) : 'Free' }}</div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <div style="font-size: 13px; color: #6c757d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Start Date</div>
                        <div style="font-size: 16px; font-weight: 600; color: #2c3e50;">{{ $competition->start_date->format('F d, Y - H:i') }}</div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <div style="font-size: 13px; color: #6c757d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">End Date</div>
                        <div style="font-size: 16px; font-weight: 600; color: #2c3e50;">{{ $competition->end_date->format('F d, Y - H:i') }}</div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <div style="font-size: 13px; color: #6c757d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Registration Deadline</div>
                        <div style="font-size: 16px; font-weight: 600; color: #e74c3c;">{{ $competition->registration_deadline->format('F d, Y - H:i') }}</div>
                    </div>
                    
                    @if($competition->max_participants)
                    <div style="margin-bottom: 32px;">
                        <div style="font-size: 13px; color: #6c757d; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Capacity</div>
                        <div style="font-size: 16px; font-weight: 600; color: #2c3e50;">{{ $registrationCount }} / {{ $competition->max_participants }}</div>
                        <div style="background: #e9ecef; height: 8px; border-radius: 4px; margin-top: 8px; overflow: hidden;">
                            <div style="background: linear-gradient(135deg, #4A90E2, #357ABD); height: 100%; width: {{ ($registrationCount / $competition->max_participants) * 100 }}%;"></div>
                        </div>
                    </div>
                    @endif
                    
                    @if($isRegistered)
                    <div style="background: #d4edda; color: #155724; padding: 16px; border-radius: 8px; text-align: center; font-weight: 600; margin-bottom: 16px;">
                        <i class="fas fa-check-circle"></i> Already Registered
                    </div>
                    @else
                    <form action="{{ route('competitions.register', $competition) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary" style="width: 100%; font-size: 16px; padding: 16px;">
                            <i class="fas fa-user-plus"></i> Register Now
                        </button>
                    </form>
                    @endif
                    
                    <a href="{{ route('competitions.index') }}" style="display: block; text-align: center; color: #6c757d; margin-top: 16px; text-decoration: none; font-weight: 600;">
                        <i class="fas fa-arrow-left"></i> Back to Competitions
                    </a>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection