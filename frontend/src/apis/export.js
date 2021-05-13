import { baseUrl } from '../configs/api';
import { getToken } from '../utils/token';

export const exportDepartment = (departmentId) => {
  let token = getToken();
  window.location.href = `${baseUrl}/api/v1/export/department/${departmentId}?access_token=${token}`;
};

export const exportUserCheckin = (userId, month = '', year = '') => {
  let token = getToken();
  window.location.href = `${baseUrl}/api/v1/export/user-checkin/${userId}?year=${year}&month=${month}&access_token=${token}`;
};