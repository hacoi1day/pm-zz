<template>
  <b-card
      header="Tạo yêu cầu"
      header-tag="header"
    >
      <b-container fluid>
        <b-row>
          <b-col md="12">
            <b-form @submit.prevent="handleSubmit">
              
              <b-row class="my-2">
                <b-col sm="2" class="d-flex align-items-center">
                  <label for="type">Nội dung</label>
                </b-col>
                <b-col sm="4">
                  <b-form-select
                    id="type"
                    v-model="request.type"
                  >
                    <b-form-select-option v-for="(requestType, index) in requestTypes" :key="index" :value="requestType.id">{{ requestType.name }}</b-form-select-option>
                  </b-form-select>
                </b-col>
              </b-row>

              <b-row class="my-2">
                <b-col sm="2" class="d-flex align-items-center">
                  <label for="name">Từ</label>
                </b-col>
                <b-col sm="4">
                  <date-time-picker :value="request.end" :onChange="handleOnChangeEnd" />
                </b-col>

                <b-col sm="2" class="d-flex align-items-center">
                  <label for="name">đến</label>
                </b-col>
                <b-col sm="4">
                  <date-time-picker :value="request.start" :onChange="handleOnChangeStart" />
                </b-col>
              </b-row>
              <b-row class="my-2">
                <b-col sm="2" class="d-flex align-items-center">
                  <label for="phone">Số điện thoại</label>
                </b-col>
                <b-col sm="4">
                  <b-form-input
                    id="phone"
                    type="text"
                    placeholder="Nhập số điện thoại"
                    v-model="request.phone"
                  />
                </b-col>
              </b-row>

              <b-row class="my-2">
                <b-col sm="2" class="d-flex align-items-center">
                  <label for="project">Dự án</label>
                </b-col>
                <b-col sm="4">
                  <b-form-input
                    id="project"
                    type="text"
                    placeholder="Nhập tên dự án"
                    v-model="request.project"
                  />
                </b-col>
              </b-row>

              <b-row class="my-2">
                <b-col sm="2" class="d-flex align-items-center">
                  <label for="cause">Lý do</label>
                </b-col>
                <b-col sm="4">
                  <b-form-textarea
                    id="cause"
                    type="text"
                    placeholder="Nhập lý do"
                    v-model="request.cause"
                  />
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
import moment from 'moment';
import { REQUEST_TYPE } from '../../constants/request';
import { createRequest } from '../../apis/request';
import DateTimePicker from '../../components/DateTimePicker.vue';
export default {
  name: 'request-create',
  components: {
    DateTimePicker
  },
  data () {
    return {
      requestTypes: [],
      request: {
        user_id: null,
        type: null,
        start: null,
        end: null,
        phone: '',
        cause: '',
        project: '',
      }
    };
  },
  mounted () {
    this.requestTypes = REQUEST_TYPE;
  },
  methods: {
    handleOnChangeStart (value) {
      this.request.start = value;
    },
    handleOnChangeEnd (value) {
      this.request.end = value;
    },
    async handleSubmit () {
      this.$Progress.start();
      let request = this.request;
      request.start = moment(request.start).format('YYYY-MM-DD HH:mm:ss');
      request.end = moment(request.end).format('YYYY-MM-DD HH:mm:ss');
      await createRequest(request);
      this.$Progress.finish();
      this.$notify({
        type: 'success',
        title: 'Thành công',
        text: 'Tạo yêu cầu thành công !'
      });
      this.$router.push({name: 'request-list'});
    }
  },
  filters: {
    filterDate (date) {
      if (!date) return '';
      return moment(date, 'DD/MM/YYYY h:mm A').format('HH:mm DD/MM/YYYY');
    }
  }
}
</script>

<style>

</style>