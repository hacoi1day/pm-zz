<template>
  <div>
    <b-card
      header="Danh sách phòng ban"
      header-tag="header"
    >
      <b-container fluid>
        <b-row>
          <b-col sm="12">
            <b-table-simple id="table-data">
              <b-thead>
                <b-tr>
                  <b-th>#</b-th>
                  <b-th>Tên Phòng ban</b-th>
                  <b-th>Quản lý</b-th>
                </b-tr>
              </b-thead>
              <b-tbody>
                <b-tr v-for="(item, index) in items" :key="index">
                  <b-td class="action">
                    <span class="edit-action mr-2" @click="editDepartment(item.id)">
                      <font-awesome-icon icon="pencil-alt"/>
                    </span>
                    <span class="delete-action" @click="deleteDepartment(item.id)">
                      <font-awesome-icon icon="trash"/>
                    </span>
                  </b-td>
                  <b-td>{{ item.name }}</b-td>
                  <b-td>{{ item.manager | filterManager }}</b-td>
                </b-tr>
              </b-tbody>
            </b-table-simple>
            <span>Trang: {{ currentPage }}/{{ lastPage }} (tổng bản ghi: {{ total }})</span>
            <b-pagination
              v-if="lastPage > 1"
              class="float-right"
              v-model="currentPage"
              :total-rows="total"
              :per-page="10"
              aria-controls="table-data"
            ></b-pagination>
          </b-col>
        </b-row>
      </b-container>
    </b-card>
  </div>
</template>

<script>
import {deleteDepartment, listDepartment} from '../../apis/department';
import swal from 'sweetalert';
export default {
  name: 'department-list',
  data () {
    return {
      currentPage: 1,
      lastPage: 1,
      items: [],
      total: 0
    };
  },
  created () {
    this.getDepartments();
  },
  watch: {
    currentPage (value) {
      this.getDepartments(value);
    }
  },
  methods: {
    async getDepartments () {
      const {data, last_page, total} = await listDepartment(this.currentPage);
      this.items = data;
      this.lastPage = last_page;
      this.total = total;
    },
    editDepartment (departmentId) {
      this.$router.push({name: 'department-edit', params: {id: departmentId}});
    },
    deleteDepartment (departmentId) {
      swal({
        title: "Chắc chắn xoá?",
        text: "Sau khi xoá, dữ liệu sẽ không thể khôi phục",
        icon: "warning",
        buttons: ['Huỷ', 'Đồng ý'],
        dangerMode: true,
      }).then(async (willDelete) => {
        if (willDelete) {
          await deleteDepartment(departmentId);
          this.currentPage = 1;
          await this.getDepartments();
          this.$notify({
            type: 'success',
            title: 'Thành công',
            text: 'Xoá Phòng ban mới thành công !'
          });
        }
      });
    }
  },
  filters: {
    filterManager (manager) {
      if (manager && manager.name) {
        return manager.name;
      }
      return '';
    }
  }
}
</script>

<style lang="scss" scope>

</style>