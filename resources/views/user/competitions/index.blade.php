@extends('layouts.user')

@section('title', 'Browse Competitions')

@section('content')
<div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 32px;">
    <h1 style="font-size: 36px; font-weight: 800; color: #2c3e50; margin-bottom: 12px;">Discover Competitions</h1>
    <p style="font-size: 16px; color: #6c757d;">Find and join exciting competitions across various categories</p>
</div>

<div style="display: grid; grid-template-columns: 280px 1fr; gap: 32px;">
    <aside style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); height: fit-content; position: sticky; top: 100px;">
        <h3 style="font-size: 18px; font-weight: 700; color: #2c3e50; margin-bottom: 20px;">Filters</h3>
        
        <form method="GET" action="{{ route('competitions.index') }}" id="filterForm">
            <div style="margin-bottom: 24px;">
                <label style="font-size: 14px; font-weight: 600; color: #495057; display: block; margin-bottom: 12px;">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search competitions..." style="width: 100%; padding: 10px 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px; transition: all 0.3s;" onfocus="this.style.borderColor='#4A90E2'" onblur="this.style.borderColor='#e9ecef'">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="font-size: 14px; font-weight: 600; color: #495057; display: block; margin-bottom: 12px;">Category</label>
                <select name="category" style="width: 100%; padding: 10px 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px;" onchange="document.getElementById('filterForm').submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="font-size: 14px; font-weight: 600; color: #495057; display: block; margin-bottom: 12px;">Sort By</label>
                <select name="sort" style="width: 100%; padding: 10px 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px;" onchange="document.getElementById('filterForm').submit()">
                    <option value="new" {{ request('sort') == 'new' ? 'selected' : '' }}>Newest</option>
                    <option value="trending" {{ request('sort') == 'trending' ? 'selected' : '' }}>Trending</option>
                    <option value="most_registrations" {{ request('sort') == 'most_registrations' ? 'selected' : '' }}>Most Popular</option>
                </select>
            </div>

            <button type="submit" style="width: 100%; background: linear-gradient(135deg, #4A90E2, #357ABD); color: white; padding: 12px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                Apply Filters
            </button>

            @if(request()->hasAny(['search', 'category', 'sort']))
            <a href="{{ route('competitions.index') }}" style="width: 100%; display: block; text-align: center; color: #e74c3c; padding: 12px; margin-top: 12px; text-decoration: none; font-weight: 600;">
                Clear All
            </a>
            @endif
        </form>
    </aside>

    <div>
        @if($competitions->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
            @foreach($competitions as $competition)
            <article style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: all 0.3s; cursor: pointer; position: relative;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'" onclick="window.location='{{ route('competitions.show', $competition->slug) }}'">
                @if($competition->image)
                <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden;">
                    <img src="{{ asset('storage/' . $competition->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; top: 12px; right: 12px; background: rgba(255,255,255,0.95); padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; color: #4A90E2;">
                        <i class="fas fa-eye"></i> {{ $competition->views }}
                    </div>
                </div>
                @else
                <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; position: relative;">
                    <i class="fas fa-trophy" style="font-size: 64px; color: rgba(255,255,255,0.3);"></i>
                    <div style="position: absolute; top: 12px; right: 12px; background: rgba(255,255,255,0.95); padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; color: #4A90E2;">
                        <i class="fas fa-eye"></i> {{ $competition->views }}
                    </div>
                </div>
                @endif

                <div style="padding: 24px;">
                    <div style="margin-bottom: 12px;">
                        <span style="background: #e3f2fd; color: #1976d2; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                            {{ $competition->category->name }}
                        </span>
                    </div>

                    <h3 style="font-size: 20px; font-weight: 700; color: #2c3e50; margin-bottom: 12px; line-height: 1.4;">{{ $competition->title }}</h3>
                    
                    <p style="font-size: 14px; color: #6c757d; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $competition->description }}
                    </p>

                    <div style="display: flex; gap: 16px; margin-bottom: 20px; padding: 16px 0; border-top: 1px solid #e9ecef; border-bottom: 1px solid #e9ecef;">
                        <div style="flex: 1;">
                            <div style="font-size: 11px; color: #95a5a6; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Registration Ends</div>
                            <div style="font-size: 13px; font-weight: 600; color: #2c3e50;">{{ $competition->registration_deadline->format('M d, Y') }}</div>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 11px; color: #95a5a6; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Entry Fee</div>
                            <div style="font-size: 13px; font-weight: 600; color: #2c3e50;">{{ $competition->entry_fee > 0 ? '$' . $competition->entry_fee : 'Free' }}</div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 13px; color: #6c757d; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-users" style="color: #4A90E2;"></i>
                            {{ $competition->confirmedRegistrations()->count() }} registered
                        </span>
                        <span style="color: #4A90E2; font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                            View Details <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div style="margin-top: 40px;">
            {{ $competitions->links() }}
        </div>
        @else
        <div style="background: white; border-radius: 16px; padding: 80px 40px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
            <i class="fas fa-search" style="font-size: 64px; color: #e9ecef; margin-bottom: 24px;"></i>
            <h3 style="font-size: 24px; font-weight: 700; color: #2c3e50; margin-bottom: 12px;">No competitions found</h3>
            <p style="font-size: 16px; color: #6c757d; margin-bottom: 32px;">Try adjusting your filters or search terms</p>
            <a href="{{ route('competitions.index') }}" class="btn-primary">Clear Filters</a>
        </div>
        @endif
    </div>
</div>
@endsection