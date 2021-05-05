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
            <b-table-simple hover small responsive="sm" v-if="userInfo">
              <b-tbody>
                <b-tr>
                  <b-td>Họ và tên</b-td>
                  <b-td>{{ userInfo.name }}</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Địa chỉ Email</b-td>
                  <b-td>{{ userInfo.email }}</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Số điện thoại</b-td>
                  <b-td>{{ userInfo.phone }}</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Ngày sinh</b-td>
                  <b-td>{{ userInfo.birthday | filterBirthday }}</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Giới tính</b-td>
                  <b-td>{{ userInfo.gender | filterGender }}</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Địa chỉ</b-td>
                  <b-td>{{ userInfo.address }}</b-td>
                </b-tr>
              </b-tbody>
            </b-table-simple>
          </b-col>
          <b-col md="6" v-if="userInfo && userInfo.department">
            <p>Thông tin nhóm dự án</p>
            <b-table-simple hover small responsive="sm">
              <b-thead>
                <b-th>Dự án</b-th>
                <b-th>Quản lý</b-th>
              </b-thead>
              <b-tbody>
                <b-tr>
                  <b-td v-if="userInfo.department.name">{{ userInfo.department.name }}</b-td>
                  <b-td v-if="userInfo.department.manager">{{ userInfo.department.manager.name }}</b-td>
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
import moment from 'moment';
import { mapState } from 'vuex'
export default {
  name: 'user-info',
  computed: mapState({
    userInfo: state => state.user.userInfo
  }),
  data () {
    return {
      
    }
  },
  created () {
    
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
        case 1:
          return 'Nam';
        case false:
        case 0:
          return 'Nữ';
        default:
          return '';
      }
    },
    filterBirthday (value) {
      if (!value) {
        return '';
      }
      return moment(value, 'YYYY-MM-DD').format('DD/MM/YYYY');
    }
  }
}
</script>

<style lang="scss">

</style>