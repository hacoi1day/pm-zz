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

export const getCheckIn = async () => {
  try {
    const {data} = await httpHelper.get('checkin/me/checkin');
    return data;
  } catch (err) {
    console.log(err);
    return null;
  }
}

export const getCheckOut = async () => {
  try {
    const {data} = await httpHelper.get('checkin/me/checkout');
    return data;
  } catch (err) {
    console.log(err);
    return null;
  }
}

export const getLastCheckIn = async () => {
  try {
    const {data} = await httpHelper.get('checkin/me/last-checkin');
    return data;
  } catch (err) {
    console.log(err);
    return null;
  }
}
