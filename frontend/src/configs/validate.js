import { extend } from 'vee-validate';
import { 
  required, 
  min, 
  max 
} from 'vee-validate/dist/rules';


extend('required', {
  ...required,
  message: '{_field_} chưa được nhập.'
});

extend('min', {
  ...min,
  message: '{_field_} phải lớn hơn {length} ký tự.'
});

extend('max', {
  ...max,
  message: '{_field_} phải nhỏ hơn {length} ký tự.'
});
