<template>
  <b-card
    header="Xử lý yêu cầu"
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
        <b-col sm="12">
          <b-tabs>
            <b-tab :active="index === 0" v-for="(status, index) of statuses" :key="index" @click="changeStatus(status.id)">
              <template #title>{{ status.name }}</template>
            </b-tab>
          </b-tabs>
          <div class="tab-content">
            <b-table-simple id="table-data" hover>
              <b-thead>
                <b-tr>
                  <b-th>Họ tên</b-th>
                  <b-th>Email</b-th>
                  <b-th>Nội dung</b-th>
                  <b-th>Trạng thái</b-th>
                  <b-th>Người xử lý</b-th>
                  <b-th>Thời hạn</b-th>
                </b-tr>
              </b-thead>
              <b-tbody>
                <b-tr v-for="(item, index) in items" :key="index" @click="openModalRequest(item.id)">
                  <b-td>{{ item.name }}</b-td>
                  <b-td>{{ item.email }}</b-td>
                  <b-td>{{ item.type | filterType }}</b-td>
                  <b-td>{{ item.status | filterStatus }}</b-td>
                  <b-td>{{ item.approval | filterApproval }}</b-td>
                  <b-td>{{ item.start | filterDate }} - {{ item.end | filterDate }}</b-td>
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
          </div>
        </b-col>
      </b-row>
    </b-container>
    <b-modal ref="modalRequest" hide-footer title="Thông tin yêu cầu">
      <div class="d-block" v-if="requestSelected">
        <p><strong>Họ tên:</strong> {{ requestSelected.user.name }}</p>
        <p><strong>Email:</strong> {{ requestSelected.user.email }}</p>
        <p><strong>Từ:</strong> {{ requestSelected.start | filterDate }}</p>
        <p><strong>Đến:</strong> {{ requestSelected.end | filterDate }}</p>
        <p><strong>Dự án:</strong> {{ requestSelected.project }}</p>
        <p><strong>Lý do:</strong> {{ requestSelected.cause }}</p>
        <hr>
        <div class="text-center">
          <b-button variant="success" class="mr-2" @click="onApproval">Phê duyệt</b-button>
          <b-button variant="danger" @click="onRefuse">Từ chôi</b-button>
        </div>
      </div>
    </b-modal>
  </b-card>
</template>

<script>
import moment from 'moment';
import { REQUEST_STATUS, REQUEST_TYPE } from '../../constants/request';
import { approvalRequest, listManagerDepartment, listRequestByDepartment, refuseRequest } from '../../apis/manager';
import { getRequest } from '../../apis/request';
import swal from 'sweetalert';

export default {
  name: 'manager-request',
  data () {
    return {
      statuses: REQUEST_STATUS,
      currentStatusId: REQUEST_STATUS[0].id,

      departmentId: null,
      departments: [],

      currentPage: 1,
      lastPage: 1,
      items: [],
      total: 0,

      requestSelectedId: null,
      requestSelected: null,
    }
  },
  watch: {
    departments () {
      if (this.departments.length > 0) {
        this.departmentId = this.departments[0].id
      }
    },
    departmentId () {
      this.fetchRequestList();
    },

    currentStatusId () {
      this.fetchRequestList();
    },
    
    requestSelectedId () {
      this.fetchRequest();
    }
  },
  created () {
    this.getListDepartment();
  },
  methods: {
    async getListDepartment () {
      const {departments} = await listManagerDepartment();
      if (departments) {
        this.departments = departments;
      }
    },
    async fetchRequestList () {
      const {data, last_page, total} = await listRequestByDepartment(this.departmentId, this.currentStatusId);
      this.items = data;
      this.lastPage = last_page;
      this.total = total;
    },
    async fetchRequest () {
      const res = await getRequest(this.requestSelectedId);
      this.requestSelected = res;
    },
    changeStatus (statusId) {
      this.currentStatusId = statusId
    },
    openModalRequest (requestId) {
      this.requestSelectedId = requestId;
      this.$refs['modalRequest'].show()
    },
    async onApproval () {
      swal({
        title: "Phê duyệt ?",
        text: "Xác nhận Phê duyệt yêu cầu",
        icon: "warning",
        buttons: ['Huỷ', 'Đồng ý'],
        dangerMode: true,
      }).then(async (willAccept) => {
        if (willAccept) {
          await approvalRequest(this.requestSelectedId);
          this.$refs['modalRequest'].hide()
          this.$notify({
            type: 'success',
            title: 'Thành công',
            text: 'Phê duyệt yêu cầu thành công !'
          });
          this.fetchRequestList();
        }
      });
    },
    async onRefuse () {
      swal({
        title: "Phê duyệt ?",
        text: "Xác nhận Phê duyệt yêu cầu",
        icon: "warning",
        buttons: ['Huỷ', 'Đồng ý'],
        dangerMode: true,
      }).then(async (willAccept) => {
        if (willAccept) {
          await refuseRequest(this.requestSelectedId);
          this.$refs['modalRequest'].hide()
          this.$notify({
            type: 'success',
            title: 'Thành công',
            text: 'Từ chối yêu cầu thành công !'
          });
          this.fetchRequestList();
        }
      });
      
    },
  },
  filters: {
    filterDate (value) {
      if (value) {
        return moment(value).format('HH:mm DD/MM/YYYY');
      }
      return '';
    },
    filterType (value) {
      let type = REQUEST_TYPE.find(item => item.id === value);
      if (type && type.name) {
        return type.name;
      }
      return '';
    },
    filterStatus (value) {
      let status = REQUEST_STATUS.find(item => item.id === value);
      if (status && status.name) {
        return status.name;
      }
      return '';
    },
    filterApproval (value) {
      if (value && value.name) {
        return value.name;
      }
      return '';
    }
  }
}
</script>

<style>

</style>