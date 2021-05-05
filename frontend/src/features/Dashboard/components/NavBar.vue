<template>
  <b-navbar toggleable="lg" type="light">
    <b-navbar-brand href="#">PM</b-navbar-brand>
    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
    <b-collapse id="nav-collapse" is-nav>
      <!-- <b-navbar-nav>
        <b-nav-item href="#">Link</b-nav-item>
      </b-navbar-nav> -->

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-item-dropdown right>
          <!-- Using 'button-content' slot -->
          <template #button-content>
            <em v-if="userInfo && userInfo.name">{{ userInfo.name }}</em>
          </template>
          <b-dropdown-item @click="showInfo">Thông tin</b-dropdown-item>
          <b-dropdown-item @click="changePassword">Đổi mật khẩu</b-dropdown-item>
          <b-dropdown-item @click="onLogout">Đăng xuất</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
import { mapState } from 'vuex';
import { logout } from '../../../apis/auth';
import { removeToken } from '../../../utils/token';

export default {
  name: 'nav-bar',
  data () {
    return {

    };
  },
  computed: mapState({
    userInfo: state => state.user.userInfo
  }),
  created () {

  },
  methods: {
    showInfo () {
      this.$router.push({name: 'info'});
    },
    changePassword () {
      this.$router.push({name: 'change-password'});
    },
    async onLogout () {
      await logout();
      removeToken();
      this.$store.commit('clearUser');
      this.$router.push({name: 'login'});
    }
  }
}
</script>

<style>

</style>