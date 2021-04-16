<template>
  <b-card
      header="Lịch làm việc"
      header-tag="header"
    >
    <FullCalendar :options="calendarOptions" />
  </b-card>
</template>

<script>
import FullCalendar from '@fullcalendar/vue';
import viLocale from '@fullcalendar/core/locales/vi';
import dayGridPlugin from '@fullcalendar/daygrid';
import moment from 'moment';

export default {
  name: 'check-in',
  components: {
    FullCalendar,
  },
  data () {
    return {
      calendarOptions: {
        plugins: [ dayGridPlugin ],
        initialView: 'dayGridMonth',
        locales: [ viLocale ],
        locale: 'vi',
        events: [
          { title: 'Test 1', date: '2021-04-15', time_in: '09:00:00', time_out: '18:00:00' },
        ],
        eventContent: (arg) => {
          let {time_in, time_out} = arg.event.extendedProps;
          return {
            html : `
              <span class="time_in">${moment(time_in, 'HH:mm:ss').format('HH:mm')}</span>
              <span class="time_out">${moment(time_out, 'HH:mm:ss').format('HH:mm')}</span>
            `
          };
        }
      }
    }
  }
}
</script>

<style lang="scss">
.fc-daygrid-event {
  border: none!important;
  background-color: transparent!important;
  .fc-event-main {
    color: white;
    text-align: center;
    span {
      display: inline-block;
      border-radius: 8px;
      padding: 2px 10px;
    }

    .time_in {
      background-color: #3154d6;
    }
    .time_out {
      background-color: #1e9c0f;
    }
  }
}

</style>