<template>
  <vc-date-picker 
    title-position="center" 
    mode="dateTime"
    is24hr
    :popover="{ visibility: 'click' }"
    locale="vi"
    v-model="dateTime"
  >
    <template v-slot="{ inputValue, inputEvents }">
      <b-input
        :value="inputValue | filterDate"
        v-on="inputEvents"
      />
    </template>
  </vc-date-picker>
</template>

<script>
import moment from 'moment';
export default {
  name: 'date-time-picker',
  props: {
    value: String,
    onChange: Function
  },
  data () {
    return {
      dateTime: null,
    }
  },
  mounted () {
    this.dateTime = this.value;
  },
  created () {
    // console.log(this.dateTime);
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