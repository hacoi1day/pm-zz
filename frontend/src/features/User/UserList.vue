<template>
  <div>
    <b-card
      header="Danh sách nhân viên"
      header-tag="header"
    >
      <b-container fluid>
        <b-row>
          <b-col sm="12">
            <b-table-simple id="table-data">
              <b-thead>
                <b-tr>
                  <b-th>#</b-th>
                  <b-th>Tên Nhân viên</b-th>
                  <b-th>Email</b-th>
                  <b-th>Số điện thoại</b-th>
                  <b-th>Ngày sinh</b-th>
                  <b-th>Phòng ban</b-th>
                </b-tr>
              </b-thead>
              <b-tbody>
                <b-tr v-for="(item, index) in items" :key="index">
                  <b-td class="action">
                    <span class="edit-action mr-2" @click="editUser(item.id)">
                      <font-awesome-icon icon="pencil-alt"/>
                    </span>
                    <span class="delete-action" @click="deleteUser(item.id)">
                      <font-awesome-icon icon="trash"/>
                    </span>
                  </b-td>
                  <b-td>{{ item.name }}</b-td>
                  <b-td>{{ item.email }}</b-td>
                  <b-td>{{ item.phone }}</b-td>
                  <b-td>{{ item.birthday | filterDate }}</b-td>
                  <b-td>{{ item.department | filterDepartment }}</b-td>
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
import moment from 'moment';
import swal from 'sweetalert';
import { listUser, deleteUser } from '../../apis/user';
export default {
  name: 'user-list',
  data () {
    return {
      currentPage: 1,
      lastPage: 1,
      items: [],
      total: 0
    };
  },
  created () {
    this.getUsers();
  },
  watch: {
    currentPage (value) {
      this.getUsers(value);
    }
  },
  methods: {
    async getUsers () {
      const {data, last_page, total} = await listUser(this.currentPage);
      this.items = data;
      this.lastPage = last_page;
      this.total = total;
    },
    editUser (userId) {
      this.$router.push({name: 'user-edit', params: {id: userId}});
    },
    async deleteUser (userId) {
      swal({
        title: "Chắc chắn xoá?",
        text: "Sau khi xoá, dữ liệu sẽ không thể khôi phục",
        icon: "warning",
        buttons: ['Huỷ', 'Đồng ý'],
        dangerMode: true,
      }).then(async (willDelete) => {
        if (willDelete) {
          await deleteUser(userId);
          this.currentPage = 1;
          await this.getUsers();
        }
      });
      
    }
  },
  filters: {
    filterDate (date) {
      if (date) {
        return moment(date).format('DD/MM/YYYY');
      }
      return date;
    },
    filterDepartment (department) {
      if (department && department.name) {
        return department.name;
      }
      return '';
    }
  }
}
</script>

<style>

</style>