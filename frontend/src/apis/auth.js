import axiosInstance from '../utils/axiosInstance';

export const login = async (email, password) => {
    try {
        const {data} = await axiosInstance.post('login', {
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
        const {data} = await axiosInstance.post('reset-password', {
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
        const {data} = await axiosInstance.get('me');
        return data;
    } catch(err) {
        console.log(err);
        return false;
    }
};

export const logout = async () => {
    try {
        const {data} = await axiosInstance.get('logout');
        return data;
    } catch (err) {
        console.log(err);
        return false;
    }
};
