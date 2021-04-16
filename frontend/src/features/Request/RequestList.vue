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
}
</script>

<style>

</style>