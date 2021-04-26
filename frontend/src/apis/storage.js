import httpHelper from '../utils/httpHelper';

export const storeFile = async (file) => {
    const {data} = await httpHelper.uploadFile(file);
    return data;
};
