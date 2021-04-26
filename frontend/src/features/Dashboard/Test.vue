<template>
  <b-card
    header="Test"
    header-tag="header"
  >
    <h2>Test</h2>
    <hr>
    
    <button @click="decrement">Decrement</button>
    <span>{{ count }}</span>
    <button @click="increment">Increment</button>

  </b-card>
</template>

<script>
import { mapState } from 'vuex'
export default {
  name: 'test',
  computed: mapState({
    count: state => state.counter.count
  }),
  watch: {
    count (value) {
      console.log(value);
    }
  },
  methods: {
    increment () {
      this.$store.commit('increment');
    },
    decrement () {
      this.$store.commit('decrement');
    }
  }
}
</script>

<style>

</style>