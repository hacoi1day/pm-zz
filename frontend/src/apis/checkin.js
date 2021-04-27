import httpHelper from '../utils/httpHelper';

export const getCalendar = async (start_date, end_date) => {
  try {
    const {data} = await httpHelper.get(`checkin/calendar?start_date=${start_date}&end_date=${end_date}`);
    return data;
  } catch (err) {
    console.log(err);
    return [];
  }
};
