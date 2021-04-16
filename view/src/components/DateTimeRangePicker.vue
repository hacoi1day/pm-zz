<template>
  <vc-date-picker 
    title-position="center" 
    mode="dateTime"
    :is24hr="true"
    locale="vi"
    v-model="ranger"
    :popover="{ visibility: 'click' }"
    is-range
  >
    <template v-slot="{ inputValue, inputEvents }">
      <b-input-group>
        <b-input
          :value="inputValue.start | filterDate"
          v-on="inputEvents.start"
        />
        <b-input
          :value="inputValue.end | filterDate"
          v-on="inputEvents.end"
        />
      </b-input-group>
      
    </template>
  </vc-date-picker>
</template>

<script>
import moment from 'moment';
export default {
  name: 'date-time-range-picker',
  props: [
    'value',
    'onChange'
  ],
  data () {
    return {
      ranger: null,
      masks: {
        is24hr: true
      }
    }
  },
  mounted () {
  },
  created () {
  },
  watch: {
    dateTime (value) {
      // console.log(value);
      this.onChange(value);
    }
  },
  filters: {
    filterDate (date) {
      if (!date) return '';
      return moment(date, 'DD/MM/YYYY h:mm A').format('HH:mm DD/MM/YYYY');
    }
  }
}
</script>

<style>

</style>