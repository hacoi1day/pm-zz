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
            <b-table-simple id="table-data">
              <b-thead>
                <b-tr>
                  <b-th>Nội dung</b-th>
                  <b-th>Trạng thái</b-th>
                  <b-th>Người xử lý</b-th>
                  <b-th>Thời hạn</b-th>
                </b-tr>
              </b-thead>
              <b-tbody>
                <b-tr v-for="(item, index) in items" :key="index">
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
  </b-card>
</template>

<script>
import moment from 'moment';
import { REQUEST_STATUS, REQUEST_TYPE } from '../../constants/request';
import { listManagerDepartment, listRequestByDepartment } from '../../apis/manager';

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
      total: 0
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
      console.log(data, last_page, total);
      this.items = data;
      this.lastPage = last_page;
      this.total = total;
    },
    changeStatus (statusId) {
      this.currentStatusId = statusId
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