import axiosInstance from '../utils/axiosInstance';

export const storeFile = async (file) => {
    const {data} = await axiosInstance.uploadFile(file);
    return data;
};
