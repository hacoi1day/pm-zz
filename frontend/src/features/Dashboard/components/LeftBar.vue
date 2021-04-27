<template>
  <div class="left-bar">
    <menu-dropdown
      v-for="router of routers"
      :key="router.id"
      :router="router"
    />
  </div>
</template>

<script>
import MenuDropdown from '../../../components/menu/MenuDropdown'
export default {
  name: 'left-bar',
  components: {
    'menu-dropdown': MenuDropdown
  },
  data () {
    return {
      routers: [
        {
          id: 100,
          title: 'Nhân viên',
          children: [
            { id: 101, title: 'Danh sách', link: '/user/list' },
            { id: 102, title: 'Thêm mới', link: '/user/create' },
          ]
        },
        {
          id: 200,
          title: 'Phòng ban',
          children: [
            { id: 201, title: 'Danh sách', link: '/department/list' },
            { id: 202, title: 'Thêm mới', link: '/department/create' },
          ]
        },
        {
          id: 300,
          title: 'Lịch làm việc',
          link: '/check-in'
        },
        {
          id: 400,
          title: 'Yêu cầu',
          children: [
            { id: 401, title: 'Yêu cầu của tôi', link: '/request/list' },
            { id: 402, title: 'Tạo yêu cầu', link: '/request/create' },
          ]
        }
      ]
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