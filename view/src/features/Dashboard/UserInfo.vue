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
            <b-table-simple hover small responsive="sm">
              <b-tbody>
                <b-tr>
                  <b-td>Họ và tên</b-td>
                  <b-td>Vũ Thanh Hà</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Địa chỉ Email</b-td>
                  <b-td>vuha98.tn@gmail.com</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Số điện thoại</b-td>
                  <b-td>0984735879</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Ngày sinh</b-td>
                  <b-td>05/12/1998</b-td>
                </b-tr>
                <b-tr>
                  <b-td>Giới tính</b-td>
                  <b-td>Địa chỉ</b-td>
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
            <b-button variant="success">Sửa thông tin</b-button>
          </b-col>
        </b-row>
        
      </b-container>
    </b-card>
  </div>
</template>

<script>
export default {
  name: 'user-info',
  data () {
    return {
      
    }
  }
}
</script>

<style lang="scss">

</style>