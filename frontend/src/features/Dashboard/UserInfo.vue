<template>
  <div class="user-info">
    <b-card
      header="Thông tin cá nhân"
      header-tag="header"
    >
      <b-container fluid>
        <b-row>
          <b-col md="6">
            <p>Thông tin nhân viên</p>
            <b-table-simple hover small responsive="sm" v-if="user">
              <b-tbody>
                <b-tr>
                  <b-td>Họ và tên</b-td>
                  <b-td>{{ user.name }}</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Địa chỉ Email</b-td>
                  <b-td>{{ user.email }}</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Số điện thoại</b-td>
                  <b-td>{{ user.phone }}</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Ngày sinh</b-td>
                  <b-td>{{ user.birthday }}</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Giới tính</b-td>
                  <b-td>{{ user.gender | filterGender }}</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Địa chỉ</b-td>
                  <b-td>{{ user.address }}</b-td>
                </b-tr>
              </b-tbody>
            </b-table-simple>
          </b-col>
          <b-col md="6">
            <p>Thông tin nhóm dự án</p>
            <b-table-simple hover small responsive="sm">
              <b-thead>
                <b-th>Dự án</b-th>
                <b-th>Quản lý</b-th>
              </b-thead>
              <b-tbody>
                <b-tr>
                  <b-td>Intern</b-td>
                  <b-td>Root</b-td>
                </b-tr>
              </b-tbody>
            </b-table-simple>
          </b-col>
          <b-col md="12">
            <b-button variant="success" @click="editUserInfo">Sửa thông tin</b-button>
          </b-col>
        </b-row>
      </b-container>
    </b-card>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  name: 'user-info',
  created () {
  },
  computed: mapState({
    user: state => state.user.userInfo
  }),
  data () {
    return {
      
    }
  },
  methods: {
    editUserInfo () {
      this.$router.push({name: 'user-info-edit'});
    }
  },
  filters: {
    filterGender (value) {
      switch (value) {
        case true:
          return 'Nam';
        case false:
          return 'Nữ';
        default:
          return '';
      }
    }
  }
}
</script>

<style lang="scss">

</style>