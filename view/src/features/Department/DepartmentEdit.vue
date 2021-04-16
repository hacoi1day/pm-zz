<template>
  <b-card
      header="Sửa thông tin phòng ban"
      header-tag="header"
    >
      <b-container fluid>
        <b-row>
          <b-col md="6">
            <b-form @submit.prevent="handleSubmit">
              <b-row class="my-2">
                <b-col sm="4">
                  <label for="name">Tên phòng ban</label>
                </b-col>
                <b-col sm="8">
                  <b-form-input
                    id="name"
                    type="text"
                    placeholder="Nhập tên phòng ban"
                    v-model="department.name"
                  ></b-form-input>
                </b-col>
              </b-row>

              <b-row class="my-2">
                <b-col sm="4">
                  <label for="name">Mô tả phòng ban</label>
                </b-col>
                <b-col sm="8">
                  <b-form-textarea
                    id="name"
                    type="text"
                    placeholder="Nhập mô tả phòng ban"
                    v-model="department.description"
                  ></b-form-textarea>
                </b-col>
              </b-row>

              <b-row class="my-2">
                <b-col sm="4">
                  <label for="manager_id">Quản lý</label>
                </b-col>
                <b-col sm="8">
                  <b-form-select
                    id="manager_id"
                    v-model="department.manager_id"
                  >
                    <b-form-select-option :value="null" disabled>Chọn nhân viên phụ trách</b-form-select-option>
                    <b-form-select-option v-for="(user, index) in users" :key="index" :value="user.id">{{ user.name }}</b-form-select-option>
                  </b-form-select>

                </b-col>
              </b-row>

              <b-row>
                <b-col sm="12" class="text-center mt-3">
                  <b-button type="submit" variant="primary">Sửa</b-button>
                </b-col>
              </b-row>
            </b-form>
          </b-col>
        </b-row>
      </b-container>
    </b-card>
</template>

<script>
import { editDepartment, getDepartment } from '../../apis/department';
import { dropdownUser } from '../../apis/user';
export default {
  data () {
    return {
      departmentId: null,
      department: {
        name: '',
        description: '',
        manager_id: null
      },
      users: []
    }
  },
  created () {
    this.departmentId = this.$route.params.id;
    this.userDropdown();
  },
  watch: {
    departmentId () {
      console.log(this.departmentId);
      this.getDepartment();
    }
  },
  methods: {
    async userDropdown () {
      let data = await dropdownUser();
      this.users = data;
    },
    async getDepartment () {
      let data = await getDepartment(this.departmentId);
      this.department = data;
    },
    async handleSubmit() {
      this.$Progress.start();
      await editDepartment(this.department);
      this.$Progress.finish();
      this.$notify({
        type: 'success',
        title: 'Thành công',
        text: 'Sửa Phòng ban mới thành công !'
      });
      this.$router.push({name: 'department-list'});
    }
  }
}
</script>

<style>

</style>