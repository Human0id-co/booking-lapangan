import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [timeGridPlugin, dayGridPlugin, interactionPlugin],
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            allDaySlot: false,
            nowIndicator: true,
            slotMinTime: "07:00:00",
            slotMaxTime: "22:00:00",
            slotDuration: '01:00:00',
            selectable: false,
            editable: false,
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            events: bookingsData.map(booking => ({
                title: booking.title || 'Booked',
                start: booking.start,
                end: booking.end,
                backgroundColor: booking.color || '#EF4444',
                borderColor: booking.color || '#EF4444',
                textColor: '#ffffff'
            })),
            eventDidMount: function (info) {
                info.el.setAttribute(
                    'title',
                    `Booked: ${info.event.start.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    })} - ${info.event.end.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    })}`
                );
            }
        });

        calendar.render();
    }
});
