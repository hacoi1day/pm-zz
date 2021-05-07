<template>
  <div class="dashboard">
    <nav-bar></nav-bar>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2 no-padding">
          <left-bar></left-bar>
        </div>
        <div class="col-md-10 content-view">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LeftBar from './components/LeftBar.vue';
import NavBar from './components/NavBar.vue';
export default {
  components: { NavBar, LeftBar },
  name: 'home',
  data () {
    return {

    };
  },
  created () {
    let {change_password} = this.$store.state.user.userInfo;
    if (change_password.length > 0) {
      this.$notify({
        type: 'warn',
        title: 'Đổi mật khẩu',
        text: 'Vui lòng đổi mật khẩu khi đăng nhập lần đầu !'
      });
      
    }
  },
  methods: {
    
  }
}
</script>

<style lang="scss">
.dashboard {
  .content-view {
    width: 100%;
    height: calc(100vh - 56px);
    overflow-y: auto;
    background-color: #d8d8d8;
    padding: 20px;
  }
}
</style>