<template>
  <div v-if="!isLoading">
    <top-bar></top-bar>
    <router-view></router-view>
    <notifications position="bottom left" width="350px" />
  </div>
</template>

<script>
import { me } from './apis/auth';
import TopBar from './components/TopBar.vue';
import { getToken } from './utils/token';
export default {
  name: 'App',
  components: {
    TopBar,
  },
  data () {
    return {
      isLoading: true
    };
  },
  async created () {
    if (getToken()) {
      let res = await me();
      this.$store.commit('setUser', res);
    }
    this.isLoading = false;
  },
  methods: {

  }
}
</script>

<style>
</style>
