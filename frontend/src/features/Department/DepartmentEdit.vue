<template>
  <b-card
    header="Sửa thông tin phòng ban"
    header-tag="header"
  >
    <b-container fluid>
      <b-row>
        <b-col md="6">
          <DepartmentForm
            mode="edit"
            :departmentId="departmentId"
            :onSubmit="handleSubmit"
          />
        </b-col>
      </b-row>
    </b-container>
  </b-card>
</template>

<script>
import { editDepartment } from '../../apis/department';
import DepartmentForm from './partials/DepartmentForm.vue';

export default {
  name: 'department-edit',
  components: {
    DepartmentForm
  },
  data () {
    return {
      departmentId: this.$route.params.id,
    }
  },
  methods: {
    async handleSubmit(form) {
      await editDepartment(form);
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