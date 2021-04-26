<template>
  <b-card
    header="Tạo yêu cầu"
    header-tag="header"
  >
    <b-container fluid>
      <b-row>
        <b-col md="12">
          <ValidationObserver v-slot="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(onSubmit)">
              <ValidationProvider 
                v-slot="{errors}" 
                rules="required" 
                name="Nội dung"
              >
              <b-form-group label="Nội dung:" label-for="type">
                <b-form-select
                  id="type"
                  v-model="request.type"
                  :state="errors.length !== 0 ? false : null"
                >
                  <b-form-select-option 
                    v-for="(requestType, index) in requestTypes" 
                    :key="index" 
                    :value="requestType.id"
                  >{{ requestType.name }}</b-form-select-option>
                </b-form-select>
                <b-form-invalid-feedback :state="errors ? false : true">
                  {{ errors[0] }}
                </b-form-invalid-feedback>
              </b-form-group>
              </ValidationProvider>

              <ValidationProvider 
                v-slot="{errors}" 
                rules="required" 
                name="Ngày"
                v-if="!selectDate"
              >
                <label for="date">Ngày:</label>
                <b-form-datepicker 
                  id="date" 
                  v-model="date" 
                  class="mb-2"
                  :state="errors.length !== 0 ? false : null"
                ></b-form-datepicker>
                <b-form-invalid-feedback :state="errors ? false : true">
                  {{ errors[0] }}
                </b-form-invalid-feedback>
              </ValidationProvider>

              <ValidationProvider 
                v-slot="{errors}" 
                rules="required" 
                name="Từ"
              >
                <label for="start">Từ:</label>
                <b-form-datepicker 
                  id="start" 
                  v-model="request.start" 
                  class="mb-2"
                  :state="errors.length !== 0 ? false : null"
                  v-if="selectDate"
                ></b-form-datepicker>
                <b-form-timepicker 
                  id="start" 
                  v-model="request.start" 
                  class="mb-2"
                  :state="errors.length !== 0 ? false : null"
                  v-if="!selectDate"
                ></b-form-timepicker>
                <b-form-invalid-feedback :state="errors ? false : true">
                  {{ errors[0] }}
                </b-form-invalid-feedback>
              </ValidationProvider>

              <ValidationProvider 
                v-slot="{errors}" 
                rules="required" 
                name="Đến"
              >
                <label for="end">Đến:</label>
                <b-form-datepicker 
                  id="end" 
                  v-model="request.end" 
                  class="mb-2"
                  :state="errors.length !== 0 ? false : null"
                  v-if="selectDate"
                ></b-form-datepicker>
                <b-form-timepicker 
                  id="end" 
                  v-model="request.end" 
                  class="mb-2"
                  :state="errors.length !== 0 ? false : null"
                  v-if="!selectDate"
                ></b-form-timepicker>
                <b-form-invalid-feedback :state="errors ? false : true">
                  {{ errors[0] }}
                </b-form-invalid-feedback>
              </ValidationProvider>

              <ValidationProvider 
                v-slot="{errors}" 
                rules="required" 
                name="Số điện thoại"
              >
                <b-form-group
                  label="Số điện thoại:"
                  label-for="phone"
                >
                  <b-form-input
                    id="phone"
                    v-model="request.phone"
                    type="text"
                    placeholder="Nhập Số điện thoại"
                    :state="errors.length !== 0 ? false : null"
                  ></b-form-input>
                  <b-form-invalid-feedback :state="errors ? false : true">
                    {{ errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>

              <ValidationProvider 
                v-slot="{errors}" 
                rules="required" 
                name="Dự án"
              >
                <b-form-group
                  label="Dự án:"
                  label-for="project"
                >
                  <b-form-input
                    id="project"
                    v-model="request.project"
                    type="text"
                    placeholder="Nhập Dự án"
                    :state="errors.length !== 0 ? false : null"
                  ></b-form-input>
                  <b-form-invalid-feedback :state="errors ? false : true">
                    {{ errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>

              <ValidationProvider 
                v-slot="{errors}" 
                rules="required" 
                name="Lý do"
              >
                <b-form-group
                  label="Lý do:"
                  label-for="cause"
                >
                  <b-form-input
                    id="cause"
                    v-model="request.cause"
                    type="text"
                    placeholder="Nhập Lý do"
                    :state="errors.length !== 0 ? false : null"
                  ></b-form-input>
                  <b-form-invalid-feedback :state="errors ? false : true">
                    {{ errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>
              <div class="text-center">
                <b-button type="submit" variant="primary">Tạo yêu cầu</b-button>
              </div>
            </b-form>
          </ValidationObserver>
        </b-col>
      </b-row>
    </b-container>
  </b-card>
</template>

<script>
import { REQUEST_TYPE } from '../../constants/request';
import { createRequest } from '../../apis/request';
import { ValidationObserver, ValidationProvider } from 'vee-validate';

export default {
  name: 'request-create',
  components: {
    ValidationObserver, ValidationProvider,
  },
  data () {
    return {
      requestTypes: REQUEST_TYPE,
      selectDate: true,
      date: '',
      request: {
        type: null,
        start: null,
        end: null,
        phone: '',
        cause: '',
        project: '',
      }
    };
  },
  created () {
    let user = this.$store.state.user.userInfo;
    if (user) {
      this.request.phone = user.phone;
      this.request.project = user.department.name;
    }
  },
  watch: {
    request: {
      handler (value) {
        switch (value.type) {
          case 1:
          case 2:
            // select date
            this.selectDate = true;
            break;
          case 3:
            // select time
            this.selectDate = false;
            break;
        }
      },
      deep: true
    }
  },
  methods: {
    handleOnChangeStart (value) {
      this.request.start = value;
    },
    handleOnChangeEnd (value) {
      this.request.end = value;
    },
    async onSubmit () {
      let request = this.request;
      if (this.selectDate === false) {
        request.start = `${this.date} ${request.start}`;
        request.end = `${this.date} ${request.end}`;
      }
      await createRequest(request);
      this.$notify({
        type: 'success',
        title: 'Thành công',
        text: 'Tạo yêu cầu thành công !'
      });
      this.$router.push({name: 'request-list'});
    },
  },
  filters: {
    
  }
}
</script>

<style>

</style>