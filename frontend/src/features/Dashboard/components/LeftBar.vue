<template>
  <div class="left-bar">
    <div v-for="router of routers" :key="router.id">
      <menu-dropdown
        v-if="router.isShow"
        :router="router"
      />
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import MenuDropdown from '../../../components/menu/MenuDropdown'
export default {
  name: 'left-bar',
  components: {
    'menu-dropdown': MenuDropdown
  },
  computed: mapState({
    userInfo: state => state.user.userInfo,
    routers: state => {
      return [
        {
          id: 100,
          title: 'Nhân viên',
          children: [
            { id: 101, title: 'Danh sách', link: '/user/list' },
            { id: 102, title: 'Thêm mới', link: '/user/create' },
          ],
          isShow: state.user.userInfo.role_id === 1
        },
        {
          id: 200,
          title: 'Phòng ban',
          children: [
            { id: 201, title: 'Danh sách', link: '/department/list' },
            { id: 202, title: 'Thêm mới', link: '/department/create' },
          ],
          isShow: state.user.userInfo.role_id === 1
        },
        {
          id: 300,
          title: 'Lịch làm việc',
          link: '/check-in',
          isShow: true,
        },
        {
          id: 400,
          title: 'Yêu cầu',
          children: [
            { id: 401, title: 'Yêu cầu của tôi', link: '/request/list' },
            { id: 402, title: 'Tạo yêu cầu', link: '/request/create' },
          ],
          isShow: true,
        },
        {
          id: 500,
          title: 'Quản lý',
          children: [
            { id: 501, title: 'Phòng ban', link: '/manager/department' },
            { id: 502, title: 'Xủ lý yêu cầu', link: '/manager/request' },
          ],
          isShow: state.user.userInfo.role_id === 1 || state.user.userInfo.role_id === 2
        }
      ];
    }
  }),
  data () {
    return {
      
    }
  }
}
</script>

<style lang="scss">
.left-bar {
  background-color: #2d90ca;
  height: calc(100vh - 56px);
  padding: 10px;
  overflow-y: auto;
}
</style>