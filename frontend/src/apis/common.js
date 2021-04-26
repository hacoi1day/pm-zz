import httpHelper from '../utils/httpHelper';

export const checkUnique = async (table, column, value, id = '') => {
  try {
    const {data} = await httpHelper.post(`common/check-unique/${table}/${column}/${id}`, {
      value
    });
    return data;
  } catch (err) {
    console.log(err);
    return false;
  }
};
