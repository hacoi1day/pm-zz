import { extend } from 'vee-validate';
import { 
  required, 
  min, 
  max,
  email
} from 'vee-validate/dist/rules';
import { checkUnique } from '../apis/common';


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

extend('email', {
  ...email,
  message: '{_field_} không đúng định dạng.'
});

extend('unique', {
  validate: async (value, args) => {
    let { table, column } = args;
    let id = '';
    if (args.id) {
      id = args.id;
    }
    let check = await checkUnique(table, column, value, id);
    if (check === 1) {
      return true;
    }
    return false;
  },
  params: ['table', 'column', 'id'],
  message: '{_field_} đã tồn tại.'
});
