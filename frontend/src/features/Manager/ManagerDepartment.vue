<template>
  <b-card
    header="Quản lý phòng ban"
    header-tag="header"
  >
    <b-container fluid>
      <b-row>
        <b-col sm="12">
          <b-form-group label="Phòng ban:" label-for="departmentId">
            <b-form-select
              id="departmentId"
              v-model="departmentId"
            >
              <b-form-select-option v-for="item in departments" :value="item.id" :key="item.id">{{ item.name }}</b-form-select-option>
            </b-form-select>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col sm="12">
          <p>Danh sách nhân viên của Phòng ban</p>
          <b-table-simple id="table-data">
            <b-thead>
              <b-tr>
                <b-th>#</b-th>
                <b-th>Tên Nhân viên</b-th>
                <b-th>Ngày sinh</b-th>
                <b-th>Email</b-th>
                <b-th>Số điện thoại</b-th>
              </b-tr>
            </b-thead>
            <b-tbody>
              <b-tr v-for="(item, index) in users" :key="index">
                <b-td>{{ item.id }}</b-td>
                <b-td>{{ item.name }}</b-td>
                <b-td>{{ item.birthday | filterBirthday }}</b-td>
                <b-td>{{ item.email }}</b-td>
                <b-td>{{ item.phone }}</b-td>
              </b-tr>
            </b-tbody>
          </b-table-simple>
        </b-col>
      </b-row>
      <b-row>
        <b-col sm="12">
          <b-button variant="primary" @click="onExportExcel">Xuất Excel</b-button>
        </b-col>
      </b-row>
    </b-container>
  </b-card>
</template>

<script>
import moment from 'moment';
import { listManagerDepartment, listUserByDepartment } from '../../apis/manager';
import { getToken } from '../../utils/token';
export default {
  name: 'manager-department',
  data () {
    return {
      departments: [],
      departmentId: null,

      users: [],
    };
  },
  created () {
    this.getListDepartment();
  },
  watch: {
    departments () {
      if (this.departments.length > 0) {
        this.departmentId = this.departments[0].id
      }
    },
    departmentId (value) {
      this.getListUserByDepartment(value);
    }
  },
  methods: {
    async getListDepartment () {
      const {departments} = await listManagerDepartment();
      if (departments) {
        this.departments = departments;
      }
    },
    async getListUserByDepartment (departmentId) {
      const {users} = await listUserByDepartment(departmentId);
      if (users) {
        this.users = users;
      }
    },
    async onExportExcel () {
      // await exportExcelDepartment(this.departmentId);
      let token = getToken();
      console.log(token);
      window.location.href = `http://api.pm.local/api/export-user/${this.departmentId}`;

    }
  },
  filters: {
    filterBirthday (birthday) {
      if (birthday) {
        return moment(birthday).format('DD/MM/YYYY');
      }
      return '';
    }
  }

}
</script>

<style>

</style>