document.addEventListener("DOMContentLoaded", function () {

    var calendar = new tui.Calendar('#calendar', {
        usageStatistics: false,
        defaultView: 'week',
        //taskView: true,
    });

    /*calendar.createSchedules([
        {
            id: '1',
            calendarId: '1',
            title: 'my schedule',
            category: 'time',
            dueDateClass: '',
            start: '2018-01-18T22:30:00+09:00',
            end: '2018-01-19T02:30:00+09:00'
        },
        {
            id: '2',
            calendarId: '1',
            title: 'second schedule',
            category: 'time',
            dueDateClass: '',
            start: '2018-01-18T17:30:00+09:00',
            end: '2018-01-19T17:31:00+09:00',
            isReadOnly: true    // schedule is read-only
        }
    ]);*/

    /*calendar.updateSchedule(schedule.id, schedule.calendarId, {
        start: startTime,
        end: endTime
    });*/

    /*calendar.deleteSchedule(schedule.id, schedule.calendarId);*/

    /*calendar.on('beforeCreateSchedule', function (event) {
        var startTime = event.start;
        var endTime = event.end;
        var isAllDay = event.isAllDay;
        var guide = event.guide;
        var triggerEventName = event.triggerEventName;
        var schedule;

        if (triggerEventName === 'click') {
            // open writing simple schedule popup
            schedule = {...};
        } else if (triggerEventName === 'dblclick') {
            // open writing detail schedule popup
            schedule = {...};
        }

        calendar.createSchedules([schedule]);
    });*/

    /*calendar.on('beforeUpdateSchedule', function(event) {
        var schedule = event.schedule;
        var changes = event.changes;

        calendar.updateSchedule(schedule.id, schedule.calendarId, changes);
    });*/

    /*calendar.on('clickSchedule', function(event) {
        var schedule = event.schedule;

        // focus the schedule
        if (lastClickSchedule) {
            calendar.updateSchedule(lastClickSchedule.id, lastClickSchedule.calendarId, {
                isFocused: false
            });
        }
        calendar.updateSchedule(schedule.id, schedule.calendarId, {
            isFocused: true
        });

        lastClickSchedule = schedule;

        // open detail view
    });*/

    /*Today
    calendar.today();

    Prev
    calendar.prev();

    Next
    calendar.next();*/

    /*// daily view
    calendar.changeView('day', true);

// weekly view
    calendar.changeView('week', true);

// monthly view with 5 weeks or 6 weeks based on the month
    calendar.setOptions({month: {isAlways6Week: false}}, true);
    calendar.changeView('month', true);

// monthly view(default 6 weeks view)
    calendar.setOptions({month: {visibleWeeksCount: 6}}, true); // or null
    calendar.changeView('month', true);

// 2 weeks monthly view
    calendar.setOptions({month: {visibleWeeksCount: 2}}, true);
    calendar.changeView('month', true);

// 3 weeks monthly view
    calendar.setOptions({month: {visibleWeeksCount: 3}}, true);
    calendar.changeView('month', true);

// narrow weekend
    calendar.setOptions({month: {narrowWeekend: true}}, true);
    calendar.setOptions({week: {narrowWeekend: true}}, true);
    calendar.changeView(calendar.getViewName(), true);

// change start day of week(from monday)
    calendar.setOptions({week: {startDayOfWeek: 1}}, true);
    calendar.setOptions({month: {startDayOfWeek: 1}}, true);
    calendar.changeView(calendar.getViewName(), true);

// work week
    calendar.setOptions({week: {workweek: true}}, true);
    calendar.setOptions({month: {workweek: true}}, true);
    calendar.changeView(calendar.getViewName(), true);*/
});

