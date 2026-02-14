@extends('layouts.user')
@section('title', 'Competition Calendar')
@section('content')
<div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
    <h1 style="font-size: 36px; font-weight: 800; color: #2c3e50; margin-bottom: 32px;">Competition Calendar</h1>
    <div id="calendar"></div>
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '/api/competitions/calendar',
        eventClick: function(info) {
            window.location.href = info.event.url;
        },
        eventColor: '#4A90E2'
    });
    calendar.render();
});
</script>
@endpush