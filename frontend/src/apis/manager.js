import httpHelper from '../utils/httpHelper';

export const listManagerDepartment = async () => {
  try {
    const {data} = await httpHelper.get('manager/list-department');
    return data;
  } catch (err) {
    console.log(err);
    return false;
  }
};

export const listUserByDepartment = async (departmentId) => {
  try {
    const {data} = await httpHelper.get(`manager/list-user-by-department/${departmentId}`);
    return data;
  } catch (err) {
    console.log(err);
    return false;
  }
}

export const listRequestByDepartment = async (departmentId, page = 1, status = '') => {
  try {
    const {data} = await httpHelper.get(`manager/list-request/${departmentId}?page=${page}&status=${status}`);
    return data;
  } catch (err) {
    console.log(err);
    return false;
  }
}

export const approvalRequest = async (requestId) => {
  try {
    const {data} = await httpHelper.get(`manager/approval-request/${requestId}`);
    return data;
  } catch (err) {
    console.log(err);
    return false;
  }
}

export const refuseRequest = async (requestId) => {
  try {
    const {data} = await httpHelper.get(`manager/refuse-request/${requestId}`);
    return data;
  } catch (err) {
    console.log(err);
    return false;
  }
}

export const exportExcelDepartment = async (departmentId) => {
  try {
    const {data} = await httpHelper.get(`manager/export-user/${departmentId}`);
    return data;
  } catch (err) {
    console.log(err);
    return false;
  }
}

export const exportExcelCheckin = async (userId) => {
  return await httpHelper.download(`manager/export-checkin/${userId}`);
  // try {
  //   const {data} = await httpHelper.get(`manager/export-checkin/${userId}`);
  //   return data;
  // } catch (err) {
  //   console.log(err);
  //   return false;
  // }
}
