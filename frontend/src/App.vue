<template>
  <div>
    <vue-progress-bar></vue-progress-bar>
    <router-view></router-view>
    <notifications position="bottom left" width="350px" />
  </div>
</template>

<script>
export default {
  name: 'App',
  components: {
  },
  methods: {
  }
}
</script>

<style>
</style>
