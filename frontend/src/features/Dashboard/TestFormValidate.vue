<template>
  <b-card
    header="Test Form Validate"
    header-tag="header"
  >
    <ValidationObserver v-slot="{ handleSubmit }">
      <b-form>
        
      </b-form>
      <form @submit.prevent="handleSubmit(onSubmit)">
        <ValidationProvider v-slot="{errors}" rules="required|min:6|max:32" name="Mật khẩu">
          <div>
            <input v-model="form.password" type="text" placeholder="Mật khẩu">
            <span>{{ errors[0] }}</span>
          </div>
        </ValidationProvider>
        <div>
          <button type="submit">Submit</button>
        </div>
      </form>
    </ValidationObserver>
  </b-card>
</template>

<script>
import { ValidationObserver, ValidationProvider } from 'vee-validate';

export default {
  name: 'test-form-validate',
  components: {
    ValidationObserver,
    ValidationProvider
  },
  data () {
    return {
      form: {
        password: '',
      }
    };
  },
  methods: {
    onSubmit () {
      console.log(this.form);
    }
  }
}
</script>

<style>

</style>