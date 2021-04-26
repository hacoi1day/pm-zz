import httpHelper from '../utils/httpHelper';

export const listUser = async (page) => {
    try {
        const {data} = await httpHelper.get(`user/user?page=${page}`);
        return data;
    } catch (err) {
        console.log(err);
        return [];
    }
};

export const createUser = async (user) => {
    try {
        const {data} = await httpHelper.post('user/user', user);
        return data;
    } catch (err) {
        console.log(err);
        return false;
    }
};

export const editUser = async (user) => {
    try {
        const {data} = await httpHelper.put(`user/user/${user.id}`, user);
        return data;
    } catch (err) {
        console.log(err);
        return false
    }
};

export const getUser = async (userId) => {
    try {
        const {data} = await httpHelper.get(`user/user/${userId}`);
    return data;
    } catch (err) {
        console.log(err);
        return false
    }
};

export const deleteUser = async (userId) => {
    try {
        const {data} = await httpHelper.delete(`user/user/${userId}`);
        return data;
    } catch (err) {
        console.log(err);
        return false;
    }
};

export const dropdownUser = async () => {
    try {
        const {data} = await httpHelper.post('user/dropdown');
        return data;
    } catch (err) {
        console.log(err);
        return [];
    }
}