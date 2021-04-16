<template>
  <b-card
      header="Thêm mới phòng ban"
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
                  <b-button type="submit" variant="primary">Thêm mới</b-button>
                </b-col>
              </b-row>
            </b-form>
          </b-col>
        </b-row>
      </b-container>
    </b-card>
</template>

<script>
import { createDepartment } from '../../apis/department';
import { dropdownUser } from '../../apis/user';
export default {
  data () {
    return {
      department: {
        name: '',
        description: '',
        manager_id: null
      },
      users: []
    }
  },
  created () {
    this.userDropdown();
  },
  methods: {
    async userDropdown () {
      let data = await dropdownUser();
      this.users = data;
    },
    async handleSubmit() {
      this.$Progress.start();
      await createDepartment(this.department);
      this.$Progress.finish();
      this.$notify({
        type: 'success',
        title: 'Thành công',
        text: 'Thêm Phòng ban mới thành công !'
      });
      this.$router.push({name: 'department-list'});
    }
  }
}
</script>

<style>

</style>