<template>
  <b-card
      header="Lịch làm việc"
      header-tag="header"
    >
    <FullCalendar 
      ref="fullCalendar"
      :options="calendarOptions"
    />
  </b-card>
</template>

<script>
import FullCalendar from '@fullcalendar/vue';
import viLocale from '@fullcalendar/core/locales/vi';
import dayGridPlugin from '@fullcalendar/daygrid';
import moment from 'moment';
import { getCalendar, getLastCheckIn, getCheckIn, getCheckOut } from '../../apis/checkin';
import swal from 'sweetalert';

export default {
  name: 'check-in',
  components: {
    FullCalendar,
  },
  data () {
    return {
      lasCheckin: null,
      type: 'checkin',
      startDate: '2021-04-01',
      endDate: '2021-04-30',
      calendarOptions: {
        plugins: [ dayGridPlugin ],
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'title',
          right: 'checkin today prev,next',
        },
        customButtons: {
          checkin: {
            text: 'Checkin',
            click: this.checkInOut
          },
          today: {
            text: 'Hôm nay',
            click: this.today
          },
          prev: {
            click: this.prevMonth
          },
          next: {
            click: this.nextMonth
          }
        },
        locales: [ viLocale ],
        locale: 'vi',
        events: [
          // { date: '2021-04-15', time_in: '2021-04-15 09:00:00', time_out: '2021-04-15 18:00:00' },
        ],
        eventContent: (arg) => {
          let { time_in, time_out } = arg.event.extendedProps;
          return {
            html : `
              ${time_in ? `<span class="time_in">${moment(time_in, 'YYYY-MM-DD HH:mm:ss').format('HH:mm')}</span>` : ''}
              ${time_out ? `<span class="time_out">${moment(time_out, 'YYYY-MM-DD HH:mm:ss').format('HH:mm')}</span>` : ''}
            `
          };
        }
      }
    }
  },
  created () {
    this.fetchLastCheckin();
    
  },
  mounted () {
    this.getRangeDate();
    this.fetchCalendar();
  },
  watch: {
    lasCheckin (lastCheckin) {
      if (lastCheckin.time_out === null) {
        this.calendarOptions.customButtons.checkin.text = 'Checkout';
        this.type = 'checkout';
      } else {
        this.calendarOptions.customButtons.checkin.text = 'Checkin';
        this.type = 'checkin';
      }
    },
    startDate () {
      this.fetchCalendar();
    },
  },
  methods: {
    async fetchCalendar () {
      let result = await getCalendar(this.startDate, this.endDate);
      this.calendarOptions.events = result;
    },
    async fetchLastCheckin () {
      let { item } = await getLastCheckIn();
      this.lasCheckin = item;
    },
    async checkInOut () {
      if (this.type === 'checkin') {
        let {item} = await getCheckIn();
        this.calendarOptions.events.push(item);
        await this.fetchLastCheckin();
        return;
      }
      if (this.type === 'checkout') {
        swal({
          title: "CheckOut ?",
          text: "Xác nhận Checkout",
          icon: "warning",
          buttons: ['Huỷ', 'Đồng ý'],
          dangerMode: true,
        }).then(async (willDelete) => {
          if (willDelete) {
            let {item} = await getCheckOut();
            this.calendarOptions.events.pop();
            this.calendarOptions.events.push(item);
            await this.fetchLastCheckin();
          }
        });
        return;
      }
    },
    today () {
      this.$refs.fullCalendar.getApi().today();
      this.getRangeDate();
    },
    prevMonth () {
      this.$refs.fullCalendar.getApi().prev();
      this.getRangeDate();
    },
    nextMonth () {
      this.$refs.fullCalendar.getApi().next();
      this.getRangeDate();
    },
    getRangeDate () {
      const { start, end } = this.$refs.fullCalendar.getApi().currentData.dateProfile.renderRange;
      this.startDate = moment(start).format('YYYY-MM-DD');
      this.endDate = moment(end).format('YYYY-MM-DD');
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