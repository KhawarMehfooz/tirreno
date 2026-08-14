import {handleAjaxError} from './utils/ErrorHandler.js?v=0.10.1';
import {fireEvent} from './utils/Event.js?v=0.10.1';

export class Clock {
    restoreClock() {
        if (document.visibilityState !== 'visible') {
            return;
        }

        const onDetailsLoaded = this.onDetailsLoaded.bind(this);
        const token = document.head.querySelector('[name=\'csrf-token\'][content]').content;

        $.ajax({
            url: `${window.app_base}/currentTime`,
            type: 'GET',
            data: {token: token},
            success: onDetailsLoaded,
            error: handleAjaxError,
        });
    }

    onDetailsLoaded(data, status) {
        if ('success' !== status || 0 === data.length) {
            return;
        }

        this.dayInput.placeholder = data.clock_day;
        this.timeInput.placeholder = `${data.clock_time_his} ${data.clock_timezone}`;

        this.offsetInput.value = data.clock_offset;
        this.datetimeInput.value = data.clock_time_ts;
        this.datetimeUtcInput.value = data.clock_time_ts_utc;

        fireEvent('clockUpdated');
    }

    updateTime() {
        let [time, tz] = this.timeInput.placeholder.split(' ');
        let [h, m, s] = time.split(':').map(x => parseInt(x, 10));
        let d = this.dayInput.placeholder;

        s += 1;
        if (s >= 60) {
            s = 0;
            m += 1;
        }

        if (m >= 60) {
            m = 0;
            h += 1;
        }

        if (h >= 24) {
            h = 0;
            d = parseInt(d, 10) + 1;

            if (d >= 366) {
                const now = new Date();
                const year = now.getFullYear() - (now.getMonth() === 0 ? 1 : 0);
                const isLeap = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);

                if (d > 366 || (d === 366 && !isLeap)) {
                    d = 0;
                }
            }

            this.dayInput.placeholder = (d < 10 ? '00' : (d < 100 ? '0' : '')) + d.toString();
        }

        h = padZero(h);
        m = padZero(m);
        s = padZero(s);

        this.timeInput.placeholder = `${h}:${m}:${s} ${tz}`;
    }

    get timeInput() {
        return document.getElementById('clock-time');
    }

    get dayInput() {
        return document.getElementById('clock-day');
    }

    get offsetInput() {
        return document.getElementById('offset');
    }

    get datetimeInput() {
        return document.getElementById('clock-datetime');
    }

    get datetimeUtcInput() {
        return document.getElementById('clock-datetime-utc');
    }
}
