import axiosInstance from '../utils/axiosInstance';

export const listDepartment = async (page) => {
    try {
        const {data} = await axiosInstance.get(`department/department?page=${page}`);
        return data;
    } catch (err) {
        console.log(err);
        return [];
    }
};

export const createDepartment = async (department) => {
    try {
        const {data} = await axiosInstance.post('department/department', department);
        return data;
    } catch (err) {
        console.log(err);
        return false;
    }
};

export const editDepartment = async (department) => {
    try {
        const {data} = await axiosInstance.put(`department/department/${department.id}`, department);
        return data;
    } catch (err) {
        console.log(err);
        return false
    }
};

export const getDepartment = async (departmentId) => {
    try {
        const {data} = await axiosInstance.get(`department/department/${departmentId}`);
    return data;
    } catch (err) {
        console.log(err);
        return false
    }
};

export const deleteDepartment = async (departmentId) => {
    try {
        const {data} = await axiosInstance.delete(`department/department/${departmentId}`);
        return data;
    } catch (err) {
        console.log(err);
        return false;
    }
};

export const dropdownDepartment = async () => {
    try {
        const {data} = await axiosInstance.post('department/dropdown');
        return data;
    } catch (err) {
        console.log(err);
        return [];
    }
}