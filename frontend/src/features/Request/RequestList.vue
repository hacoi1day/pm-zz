<template>
  <b-card
      header="Danh sách yêu cầu"
      header-tag="header"
    >
      <b-container fluid>
        <b-row>
          <b-col sm="12">
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
                  <b-td><b-badge :variant="getVariantStatus(item.status)">{{ item.status | filterStatus }}</b-badge></b-td>
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
          </b-col>
        </b-row>
      </b-container>
    </b-card>
</template>

<script>
import moment from 'moment';
import { REQUEST_STATUS, REQUEST_TYPE } from '../../constants/request';
import { myRequest } from '../../apis/request';
export default {
  name: 'request-list',
  data () {
    return {
      currentPage: 1,
      lastPage: 1,
      items: [],
      total: 0
    };
  },
  created () {
    this.getMyRequest(1);
  },
  watch: {
    currentPage (value) {
      this.getMyRequest(value);
    }
  },
  methods: {
    async getMyRequest () {
      const {data, last_page, total} = await myRequest(this.currentPage);
      this.items = data;
      this.lastPage = last_page;
      this.total = total;
    },
    getVariantStatus (status) {
      switch (status) {
        case 1:
          return 'secondary';
        case 2:
          return 'success';
        case 3:
          return 'danger';
      }
      return 'secondary';
    }
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