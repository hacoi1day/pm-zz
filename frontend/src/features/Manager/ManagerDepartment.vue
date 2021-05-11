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
                <b-th>Hành động</b-th>
              </b-tr>
            </b-thead>
            <b-tbody>
              <b-tr v-for="(item, index) in users" :key="index">
                <b-td>{{ item.id }}</b-td>
                <b-td>{{ item.name }}</b-td>
                <b-td>{{ item.birthday | filterBirthday }}</b-td>
                <b-td>{{ item.email }}</b-td>
                <b-td>{{ item.phone }}</b-td>
                <b-td>
                  <b-button-group>
                    <b-button
                      variant="primary" size="sm" 
                      v-b-tooltip.hover.left title="Thông tin Nhân viên"
                      @click="openModalUserInfo(item.id)"
                    >
                      <font-awesome-icon icon="eye" />
                    </b-button>
                    <b-button 
                      variant="success" size="sm" 
                      v-b-tooltip.hover.left title="Xuất Excel giờ làm"
                      @click="exportExcelCheckin(item.id)"
                    >
                      <font-awesome-icon icon="download" />
                    </b-button>
                  </b-button-group>
                </b-td>
              </b-tr>
            </b-tbody>
          </b-table-simple>
        </b-col>
      </b-row>
      <b-row>
        <b-col sm="12">
          <b-button 
            variant="primary" @click="onExportExcel"
            v-b-tooltip.hover.right title="Xuất Excel Danh sách nhân viên"
          >Xuất Excel</b-button>
        </b-col>
      </b-row>
    </b-container>
    <b-modal ref="modalUserInfo" hide-footer title="Thông tin nhân viên">
      <div class="d-block modal-user-info" v-if="userSelected">
        <div class="avatar">
          <img :src="userSelected.avatar" alt="avatar"  />
        </div>
        
        <p><strong>Họ tên:</strong> {{ userSelected.name }}</p>
        <p><strong>Email:</strong> {{ userSelected.email }}</p>
        <p><strong>Số điện thoại:</strong> {{ userSelected.phone }}</p>
        <p><strong>Ngày sinh:</strong> {{ userSelected.birthday | filterBirthday }}</p>
        <p><strong>Địa chỉ:</strong> {{ userSelected.address }}</p>
        <hr>
        <div class="text-center">
          <b-button variant="success" @click="closeModalUserInfo()">Đóng</b-button>
        </div>
      </div>
    </b-modal>
  </b-card>
</template>

<script>
import moment from 'moment';
import { listManagerDepartment, listUserByDepartment } from '../../apis/manager';
import { exportDepartment, exportUserCheckin } from '../../apis/export';
import { getUser } from '../../apis/user';
export default {
  name: 'manager-department',
  data () {
    return {
      departments: [],
      departmentId: null,

      users: [],
      userIdSelected: null,
      userSelected: {},
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
    },
    userIdSelected () {
      this.getUserInfo();
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
    async getUserInfo () {
      const res = await getUser(this.userIdSelected);
      this.userSelected = res;
    },
    openModalUserInfo (userId) {
      this.userIdSelected = userId;
      this.$refs['modalUserInfo'].show();
    },
    closeModalUserInfo () {
      this.$refs['modalUserInfo'].hide();
    },
    onExportExcel () {
      exportDepartment(this.departmentId);
    },
    exportExcelCheckin (userId) {
      exportUserCheckin(userId);
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

<style lang="scss">
.modal-user-info {
  .avatar {
    text-align: center;
    img {
      max-width: 150px;
      max-height: 150px;
    }
  }
  p {
    margin-bottom: 5px;
  }
}
</style>