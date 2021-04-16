import axiosInstance from '../utils/axiosInstance';

export const listRequest = async (page) => {
    try {
        const {data} = await axiosInstance.get(`request/request?page=${page}`);
        return data;
    } catch (err) {
        console.log(err);
        return [];
    }
};

export const createRequest = async (user) => {
    try {
        const {data} = await axiosInstance.post('request/request', user);
        return data;
    } catch (err) {
        console.log(err);
        return false;
    }
};

export const editRequest = async (user) => {
    try {
        const {data} = await axiosInstance.put(`request/request/${user.id}`, user);
        return data;
    } catch (err) {
        console.log(err);
        return false
    }
};

export const getRequest = async (userId) => {
    try {
        const {data} = await axiosInstance.get(`request/request/${userId}`);
    return data;
    } catch (err) {
        console.log(err);
        return false
    }
};

export const deleteRequest = async (userId) => {
    try {
        const {data} = await axiosInstance.delete(`request/request/${userId}`);
        return data;
    } catch (err) {
        console.log(err);
        return false;
    }
};
