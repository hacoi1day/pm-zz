import httpHelper from '../utils/httpHelper';

export const listRequest = async (page) => {
    try {
        const {data} = await httpHelper.get(`request/request?page=${page}`);
        return data;
    } catch (err) {
        console.log(err);
        return [];
    }
};

export const myRequest = async (page) => {
  try {
      const {data} = await httpHelper.get(`request/my-request?page=${page}`);
      return data;
  } catch (err) {
      console.log(err);
      return [];
  }
};

export const createRequest = async (request) => {
    try {
        const {data} = await httpHelper.post('request/request', request);
        return data;
    } catch (err) {
        console.log(err);
        return false;
    }
};

export const editRequest = async (request) => {
    try {
        const {data} = await httpHelper.put(`request/request/${request.id}`, request);
        return data;
    } catch (err) {
        console.log(err);
        return false
    }
};

export const getRequest = async (requestId) => {
    try {
        const {data} = await httpHelper.get(`request/request/${requestId}`);
    return data;
    } catch (err) {
        console.log(err);
        return false
    }
};

export const deleteRequest = async (requestId) => {
    try {
        const {data} = await httpHelper.delete(`request/request/${requestId}`);
        return data;
    } catch (err) {
        console.log(err);
        return false;
    }
};
