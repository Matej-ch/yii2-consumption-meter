document.addEventListener("DOMContentLoaded", function () {

    (function (window, Calendar) {
        var cal, resizeThrottled;
        let useCreationPopup = true;
        let useDetailPopup = true;
        var datePicker, selectedCalendar;
        var CalendarList = [];

        var ScheduleList = [];

        const SCHEDULE_CATEGORY = [
            'milestone',
            'task'
        ];

        function ScheduleInfo() {
            this.id = null;
            this.calendarId = null;

            this.title = null;
            this.body = null;
            this.location = null;
            this.isAllday = false;
            this.start = null;
            this.end = null;
            this.category = '';
            this.dueDateClass = '';

            this.color = null;
            this.bgColor = null;
            this.dragBgColor = null;
            this.borderColor = null;
            this.customStyle = '';

            this.isFocused = false;
            this.isPending = false;
            this.isVisible = true;
            this.isReadOnly = false;
            this.isPrivate = false;
            this.goingDuration = 0;
            this.comingDuration = 0;
            this.recurrenceRule = '';
            this.state = '';

            this.raw = {
                memo: '',
                hasToOrCc: false,
                hasRecurrenceRule: false,
                location: null,
                creator: {
                    name: '',
                    avatar: '',
                    company: '',
                    email: '',
                    phone: ''
                }
            };
        }

        function generateTime(schedule, renderStart, renderEnd) {
            let startDate = moment(renderStart.getTime())
            let endDate = moment(renderEnd.getTime());
            let diffDate = endDate.diff(startDate, 'days');
            let category;
            if (Math.floor(Math.random() * 10) > 5) {
                schedule.isAllday = true;
                category = 1;
            } else {
                schedule.isAllday = false;
                category = 0;
            }

            if (schedule.isAllday) {
                schedule.category = 'allday';
            } else if (Math.floor(Math.random() * 10) > 8) {
                schedule.category = SCHEDULE_CATEGORY[category];
                if (schedule.category === SCHEDULE_CATEGORY[1]) {
                    schedule.dueDateClass = 'morning';
                }
            } else {
                schedule.category = 'time';
            }

            startDate.add(Math.floor(Math.random() * diffDate), 'days');
            startDate.hours(Math.floor(Math.random() * 23))
            startDate.minutes(category === 0 ? 0 : 30);
            schedule.start = startDate.toDate();

            endDate = moment(startDate);
            if (schedule.isAllday) {
                endDate.add(1, 'days');
            }

            schedule.end = endDate
                .add(1, 'hour')
                .toDate();

            if (!schedule.isAllday && Math.floor(Math.random() * 10) > 8) {
                schedule.goingDuration = Math.floor(Math.random() * 90) + 30;
                schedule.comingDuration = Math.floor(Math.random() * 90) + 30;

                if (Math.floor(Math.random() * 10) >= 9) {
                    schedule.end = schedule.start;
                }
            }
        }

        function generateRandomSchedule(calendar, renderStart, renderEnd) {
            let schedule = new ScheduleInfo();

            schedule.id = 1;
            schedule.calendarId = calendar.id;

            schedule.title = 'title';
            schedule.body = 'body of event';
            schedule.isReadOnly = false;
            generateTime(schedule, renderStart, renderEnd);

            schedule.isPrivate = false;
            schedule.location = '';
            schedule.attendees = [];
            schedule.recurrenceRule = '';
            schedule.state = 'Free';
            schedule.color = calendar.color;
            schedule.bgColor = calendar.bgColor;
            schedule.dragBgColor = calendar.dragBgColor;
            schedule.borderColor = calendar.borderColor;

            if (schedule.category === 'milestone') {
                schedule.color = schedule.bgColor;
                schedule.bgColor = 'transparent';
                schedule.dragBgColor = 'transparent';
                schedule.borderColor = 'transparent';
            }

            schedule.raw.memo = 'memo';
            schedule.raw.creator.name = 'creator name';
            schedule.raw.creator.avatar = '';
            schedule.raw.creator.company = 'company';
            schedule.raw.creator.email = 'email';
            schedule.raw.creator.phone = 'phone';

            ScheduleList.push(schedule);
        }

        function generateSchedule(viewName, renderStart, renderEnd) {
            ScheduleList = [];
            CalendarList.forEach(function (calendar) {
                let i = 0, length = 10;
                if (viewName === 'month') {
                    length = 3;
                } else if (viewName === 'day') {
                    length = 4;
                }
                for (; i < length; i += 1) {
                    generateRandomSchedule(calendar, renderStart, renderEnd);
                }
            });
        }

        function CalendarInfo() {
            this.id = null;
            this.name = null;
            this.checked = true;
            this.color = null;
            this.bgColor = null;
            this.borderColor = null;
            this.dragBgColor = null;
        }

        function findCalendar(id) {
            let found;

            CalendarList.forEach(function (calendar) {
                if (calendar.id === id) {
                    found = calendar;
                }
            });

            return found || CalendarList[0];
        }

        async function initCalendars() {
            let calendar;
            let id = 1;
            let calendarList = [];
            const colors = [
                {color: '#ffffff', bgColor: '#9e5fff', dragBgColor: '#9e5fff'},
                {color: '#ffffff', bgColor: '#00a9ff', dragBgColor: '#00a9ff'},
                {color: '#ffffff', bgColor: '#ff5583', dragBgColor: '#ff5583'}
            ];

            await fetch('/iot/device/index')
                .then(res => res.json())
                .then(data => {
                    Object.values(data.devices).forEach(device => {
                        calendar = new CalendarInfo();
                        calendar.id = String(id);
                        calendar.name = device;

                        calendar.color = colors[id - 1].color;
                        calendar.bgColor = colors[id - 1].bgColor;
                        calendar.dragBgColor = colors[id - 1].dragBgColor;
                        calendar.borderColor = colors[id - 1].dragBgColor;
                        calendarList.push(calendar);
                        id += 1;
                    })
                })

            return calendarList;
        }

        cal = new Calendar('#calendar', {
            defaultView: 'week',
            useCreationPopup: useCreationPopup,
            useDetailPopup: useDetailPopup,
            calendars: CalendarList,
            template: {
                milestone: function (model) {
                    return '<span class="calendar-font-icon ic-milestone-b"></span> <span style="background-color: ' + model.bgColor + '">' + model.title + '</span>';
                },
                allday: function (schedule) {
                    return getTimeTemplate(schedule, true);
                },
                time: function (schedule) {
                    return getTimeTemplate(schedule, false);
                }
            }
        });

        // event handlers
        cal.on({
            'clickMore': function (e) {
                console.log('clickMore', e);
            },
            'clickSchedule': function (e) {
                console.log('clickSchedule', e);
            },
            'clickDayname': function (date) {
                console.log('clickDayname', date);
            },
            'beforeCreateSchedule': function (e) {
                console.log('beforeCreateSchedule', e);
                saveNewSchedule(e);
            },
            'beforeUpdateSchedule': function (e) {
                let schedule = e.schedule;
                let changes = e.changes;

                console.log('beforeUpdateSchedule', e);

                if (changes && !changes.isAllDay && schedule.category === 'allday') {
                    changes.category = 'time';
                }

                cal.updateSchedule(schedule.id, schedule.calendarId, changes);
                refreshScheduleVisibility();
            },
            'beforeDeleteSchedule': function (e) {
                console.log('beforeDeleteSchedule', e);
                cal.deleteSchedule(e.schedule.id, e.schedule.calendarId);
            },
            'afterRenderSchedule': function (e) {
                let schedule = e.schedule;
                // var element = cal.getElement(schedule.id, schedule.calendarId);
                // console.log('afterRenderSchedule', element);
            },
            'clickTimezonesCollapseBtn': function (timezonesCollapsed) {
                console.log('timezonesCollapsed', timezonesCollapsed);

                if (timezonesCollapsed) {
                    cal.setTheme({
                        'week.daygridLeft.width': '77px',
                        'week.timegridLeft.width': '77px'
                    });
                } else {
                    cal.setTheme({
                        'week.daygridLeft.width': '60px',
                        'week.timegridLeft.width': '60px'
                    });
                }

                return true;
            }
        });

        /**
         * Get time template for time and all-day
         * @param {Schedule} schedule - schedule
         * @param {boolean} isAllDay - isAllDay or hasMultiDates
         * @returns {string}
         */
        function getTimeTemplate(schedule, isAllDay) {
            let html = [];
            let start = moment(schedule.start.toUTCString());
            if (!isAllDay) {
                html.push('<strong>' + start.format('HH:mm') + '</strong> ');
            }
            if (schedule.isPrivate) {
                html.push('<span class="calendar-font-icon ic-lock-b"></span>');
                html.push(' Private');
            } else {
                if (schedule.isReadOnly) {
                    html.push('<span class="calendar-font-icon ic-readonly-b"></span>');
                } else if (schedule.recurrenceRule) {
                    html.push('<span class="calendar-font-icon ic-repeat-b"></span>');
                } else if (schedule.attendees.length) {
                    html.push('<span class="calendar-font-icon ic-user-b"></span>');
                } else if (schedule.location) {
                    html.push('<span class="calendar-font-icon ic-location-b"></span>');
                }
                html.push(' ' + schedule.title);
            }

            return html.join('');
        }

        /**
         * A listener for click the menu
         * @param {Event} e - click event
         */
        function onClickMenu(e) {
            let target = e.target.closest('a[role="menuitem"]')[0];
            let action = getDataAction(target);
            let options = cal.getOptions();
            let viewName = '';

            console.log(target);
            console.log(action);
            switch (action) {
                case 'toggle-daily':
                    viewName = 'day';
                    break;
                case 'toggle-weekly':
                    viewName = 'week';
                    break;
                case 'toggle-monthly':
                    options.month.visibleWeeksCount = 0;
                    viewName = 'month';
                    break;
                case 'toggle-weeks2':
                    options.month.visibleWeeksCount = 2;
                    viewName = 'month';
                    break;
                case 'toggle-weeks3':
                    options.month.visibleWeeksCount = 3;
                    viewName = 'month';
                    break;
                case 'toggle-narrow-weekend':
                    options.month.narrowWeekend = !options.month.narrowWeekend;
                    options.week.narrowWeekend = !options.week.narrowWeekend;
                    viewName = cal.getViewName();

                    target.querySelector('input').checked = options.month.narrowWeekend;
                    break;
                case 'toggle-start-day-1':
                    options.month.startDayOfWeek = options.month.startDayOfWeek ? 0 : 1;
                    options.week.startDayOfWeek = options.week.startDayOfWeek ? 0 : 1;
                    viewName = cal.getViewName();

                    target.querySelector('input').checked = options.month.startDayOfWeek;
                    break;
                case 'toggle-workweek':
                    options.month.workweek = !options.month.workweek;
                    options.week.workweek = !options.week.workweek;
                    viewName = cal.getViewName();

                    target.querySelector('input').checked = !options.month.workweek;
                    break;
                default:
                    break;
            }

            cal.setOptions(options, true);
            cal.changeView(viewName, true);

            setDropdownCalendarType();
            setRenderRangeText();
            setSchedules();
        }

        function onClickNavi(e) {
            const action = getDataAction(e.target);

            switch (action) {
                case 'move-prev':
                    cal.prev();
                    break;
                case 'move-next':
                    cal.next();
                    break;
                case 'move-today':
                    cal.today();
                    break;
                default:
                    return;
            }

            setRenderRangeText();
            setSchedules();
        }

        function onNewSchedule() {

            let title = document.getElementById('new-schedule-title').value;
            let location = document.getElementById('new-schedule-location').value;
            let isAllDay = document.getElementById('new-schedule-allday').checked;
            let start = datePicker.getStartDate();
            let end = datePicker.getEndDate();
            let calendar = selectedCalendar ? selectedCalendar : CalendarList[0];

            if (!title) {
                return;
            }

            cal.createSchedules([{
                id: String(Math.floor(Math.random() * 1000000)),
                calendarId: calendar.id,
                title: title,
                isAllDay: isAllDay,
                location: location,
                start: start,
                end: end,
                category: isAllDay ? 'allday' : 'time',
                dueDateClass: '',
                color: calendar.color,
                bgColor: calendar.bgColor,
                dragBgColor: calendar.bgColor,
                borderColor: calendar.borderColor,
                state: 'Busy'
            }]);

            $('#modal-new-schedule').modal('hide');
        }

        function onChangeNewScheduleCalendar(e) {
            let target = e.target.closest('a[role="menuitem"]')[0];
            let calendarId = getDataAction(target);
            changeNewScheduleCalendar(calendarId);
        }

        function changeNewScheduleCalendar(calendarId) {
            let calendarNameElement = document.getElementById('calendarName');
            let calendar = findCalendar(calendarId);
            let html = [];

            html.push('<span class="calendar-bar" style="background-color: ' + calendar.bgColor + '; border-color:' + calendar.borderColor + ';"></span>');
            html.push('<span class="calendar-name">' + calendar.name + '</span>');

            calendarNameElement.innerHTML = html.join('');

            selectedCalendar = calendar;
        }

        function createNewSchedule(event) {
            let start = event.start ? new Date(event.start.getTime()) : new Date();
            let end = event.end ? new Date(event.end.getTime()) : moment().add(1, 'hours').toDate();

            if (useCreationPopup) {
                cal.openCreationPopup({
                    start: start,
                    end: end
                });
            }
        }

        function saveNewSchedule(scheduleData) {
            let calendar = scheduleData.calendar || findCalendar(scheduleData.calendarId);
            let schedule = {
                id: String(Math.floor(Math.random() * 1000000)),
                title: scheduleData.title,
                isAllDay: scheduleData.isAllDay,
                start: scheduleData.start,
                end: scheduleData.end,
                category: scheduleData.isAllDay ? 'allday' : 'time',
                dueDateClass: '',
                color: calendar.color,
                bgColor: calendar.bgColor,
                dragBgColor: calendar.bgColor,
                borderColor: calendar.borderColor,
                location: scheduleData.location,
                isPrivate: scheduleData.isPrivate,
                state: scheduleData.state
            };
            if (calendar) {
                schedule.calendarId = calendar.id;
                schedule.color = calendar.color;
                schedule.bgColor = calendar.bgColor;
                schedule.borderColor = calendar.borderColor;
            }

            cal.createSchedules([schedule]);

            refreshScheduleVisibility();
        }

        function onChangeCalendars(e) {
            let calendarId = e.target.value;
            let checked = e.target.checked;
            let viewAll = document.querySelector('.lnb-calendars-item input');
            let calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));
            let allCheckedCalendars = true;

            if (calendarId === 'all') {
                allCheckedCalendars = checked;

                calendarElements.forEach(function (input) {
                    var span = input.parentNode;
                    input.checked = checked;
                    span.style.backgroundColor = checked ? span.style.borderColor : 'transparent';
                });

                CalendarList.forEach(function (calendar) {
                    calendar.checked = checked;
                });
            } else {
                findCalendar(calendarId).checked = checked;

                allCheckedCalendars = calendarElements.every(function (input) {
                    return input.checked;
                });

                if (allCheckedCalendars) {
                    viewAll.checked = true;
                } else {
                    viewAll.checked = false;
                }
            }

            refreshScheduleVisibility();
        }

        function refreshScheduleVisibility() {
            let calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));

            CalendarList.forEach(function (calendar) {
                cal.toggleSchedules(calendar.id, !calendar.checked, false);
            });

            cal.render(true);

            calendarElements.forEach(function (input) {
                let span = input.nextElementSibling;
                span.style.backgroundColor = input.checked ? span.style.borderColor : 'transparent';
            });
        }

        function setDropdownCalendarType() {
            let calendarTypeName = document.getElementById('calendarTypeName');
            let calendarTypeIcon = document.getElementById('calendarTypeIcon');
            let options = cal.getOptions();
            let type = cal.getViewName();
            let iconClassName;

            if (type === 'day') {
                type = 'Daily';
                iconClassName = 'calendar-icon ic_view_day';
            } else if (type === 'week') {
                type = 'Weekly';
                iconClassName = 'calendar-icon ic_view_week';
            } else if (options.month.visibleWeeksCount === 2) {
                type = '2 weeks';
                iconClassName = 'calendar-icon ic_view_week';
            } else if (options.month.visibleWeeksCount === 3) {
                type = '3 weeks';
                iconClassName = 'calendar-icon ic_view_week';
            } else {
                type = 'Monthly';
                iconClassName = 'calendar-icon ic_view_month';
            }

            calendarTypeName.innerHTML = type;
            calendarTypeIcon.className = iconClassName;
        }

        function currentCalendarDate(format) {
            let currentDate = moment([cal.getDate().getFullYear(), cal.getDate().getMonth(), cal.getDate().getDate()]);

            return currentDate.format(format);
        }

        function setRenderRangeText() {
            let renderRange = document.getElementById('renderRange');
            let options = cal.getOptions();
            let viewName = cal.getViewName();

            let html = [];
            if (viewName === 'day') {
                html.push(currentCalendarDate('YYYY.MM.DD'));
            } else if (viewName === 'month' &&
                (!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)) {
                html.push(currentCalendarDate('YYYY.MM'));
            } else {
                html.push(moment(cal.getDateRangeStart().getTime()).format('YYYY.MM.DD'));
                html.push(' ~ ');
                html.push(moment(cal.getDateRangeEnd().getTime()).format(' MM.DD'));
            }
            renderRange.innerHTML = html.join('');
        }

        function setSchedules() {
            cal.clear();
            generateSchedule(cal.getViewName(), cal.getDateRangeStart(), cal.getDateRangeEnd());
            cal.createSchedules(ScheduleList);

            refreshScheduleVisibility();
        }

        function setEventListener() {

            document.querySelector('body').addEventListener('click', e => {
                if (e.target.id === 'menu-navi') {
                    onClickNavi(e);
                }

                if (e.target.id === 'btn-save-schedule') {
                    onNewSchedule();
                }
                if (e.target.id === 'btn-new-schedule') {
                    createNewSchedule(e);
                }
                if (e.target.id === 'dropdownMenu-calendars-list') {
                    onChangeNewScheduleCalendar(e);
                }

                if (e.target.classList.contains('dropdown-menu-title') && e.target.hasAttribute('role') && e.target.getAttribute('role') === 'menuitem') {
                    onClickMenu(e);
                }

                if (e.target.id === 'lnb-calendars') {
                    onChangeCalendars(e);
                }
            });

            window.addEventListener('resize', resizeThrottled);
        }

        function getDataAction(target) {
            return target.dataset ? target.dataset.action : target.getAttribute('data-action');
        }

        resizeThrottled = tui.util.throttle(function () {
            cal.render();
        }, 50);

        window.cal = cal;

        setDropdownCalendarType();
        setRenderRangeText();
        setSchedules();
        setEventListener();

        async function renderCalendarList() {
            const calendarListEl = document.getElementById('calendarList');
            let html = [];

            let calendarList = await initCalendars();
            CalendarList = calendarList;
            calendarList.forEach(function (calendar) {
                html.push('<div class="lnb-calendars-item"><label>' +
                    '<input type="checkbox" class="tui-full-calendar-checkbox-round" value="' + calendar.id + '" checked>' +
                    '<span style="border-color: ' + calendar.borderColor + '; background-color: ' + calendar.borderColor + ';"></span>' +
                    '<span>' + calendar.name + '</span>' +
                    '</label></div>'
                );
            });
            calendarListEl.innerHTML = html.join('\n');
        }

        renderCalendarList();

    })(window, tui.Calendar);
});

