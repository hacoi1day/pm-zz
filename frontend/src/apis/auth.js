import httpHelper from '../utils/httpHelper';

export const login = async (email, password) => {
  try {
    const {data} = await httpHelper.post('login', {
      email, 
      password
    });
    return data;
  } catch (err) {
    console.log(err);
    return false;
  }
};

export const resetPassword = async (email) => {
  try {
    const {data} = await httpHelper.post('reset-password', {
      email
    });
    return data;
  } catch (err) {
    console.log(err);
    return false;
  }
}

export const me = async () => {
  try {
    const {data} = await httpHelper.get('me');
    return data;
  } catch(err) {
    console.log(err);
    return false;
  }
};

export const logout = async () => {
  try {
    const {data} = await httpHelper.get('logout');
    return data;
  } catch (err) {
    console.log(err);
    return false;
  }
};

export const changePassword = async (params) => {
  try {
    const {data} = await httpHelper.post('change-password', params);
    return data;
  } catch (err) {
    console.log(err);
    return false;
  }
}

export const changeUserInfo = async (params) => {
  try {
    const {data} = await httpHelper.post('change-user-info', params);
    return data;
  } catch (err) {
    console.log(err);
    return false;
  }
}
