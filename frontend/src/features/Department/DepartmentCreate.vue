<template>
  <b-card
      header="Thêm mới phòng ban"
      header-tag="header"
    >
      <b-container fluid>
        <b-row>
          <b-col md="6">
            <department-form
              mode="create"
              :onSubmit="handleSubmit"
            />
          </b-col>
        </b-row>
      </b-container>
    </b-card>
</template>

<script>
import { createDepartment } from '../../apis/department';
import { dropdownUser } from '../../apis/user';
import DepartmentForm from './partials/DepartmentForm.vue';
export default {
  data () {
    return {
      
    }
  },
  components: {DepartmentForm},
  created () {
    this.userDropdown();
  },
  methods: {
    async userDropdown () {
      let data = await dropdownUser();
      this.users = data;
    },
    async handleSubmit(form) {
      let res = await createDepartment(form);
      if (res) {
        this.$notify({
          type: 'success',
          title: 'Thành công',
          text: 'Thêm Phòng ban mới thành công !'
        });
        this.$router.push({name: 'department-list'});
      }
      
    }
  }
}
</script>

<style>

</style>