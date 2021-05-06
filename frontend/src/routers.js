import Vue from 'vue';
import { me } from './apis/auth';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// Home
import HomePage from './features/Dashboard/HomePage';

// Auth
import Auth from './features/Auth';
import LoginPage from './features/Auth/LoginPage';
import ResetPassword from './features/Auth/ResetPassword';
import ChangePassToken from './features/Auth/ChangePassToken';

// Dashboard
import UserInfo from './features/Dashboard/UserInfo';
import UserInfoEdit from './features/Dashboard/UserInfoEdit';
import ChangePassword from './features/Dashboard/ChangePassword';
import Test from './features/Dashboard/Test';
import TestFormValidate from './features/Dashboard/TestFormValidate';

// User
import User from './features/User';
import UserList from './features/User/UserList';
import UserCreate from './features/User/UserCreate';
import UserEdit from './features/User/UserEdit';
import UserRequest from './features/User/UserRequest';
import UserResetPassword from './features/User/UserResetPassword';

// Department
import Department from './features/Department';
import DepartmentList from './features/Department/DepartmentList';
import DepartmentCreate from './features/Department/DepartmentCreate';
import DepartmentEdit from './features/Department/DepartmentEdit';

// CheckIn - CheckOut
import CheckInOut from './features/CheckInOut';

// Request
import Request from './features/Request';
import RequestCreate from './features/Request/RequestCreate';
import RequestList from './features/Request/RequestList';

// Manager
import Manager from './features/Manager';
import ManagerDepartment from './features/Manager/ManagerDepartment';
import ManagerRequest from './features/Manager/ManagerRequest';

// Error
import Error from './features/Error';
import Error401 from './features/Error/Error401';
import Error404 from './features/Error/Error404';

const routes = [
  { 
    path: '/auth',
    component: Auth,
    redirect: { name: 'login' },
    children: [
      { path: 'login', name: 'login', component: LoginPage },
      { path: 'reset-password', name: 'reset-password', component: ResetPassword },
      { path: 'change-password', name: 'change-password-token', component: ChangePassToken },
    ]
  },
  {
    path: '/',
    name: 'home',
    component: HomePage,
    redirect: { name: 'check-in' },
    children: [
      { path: 'info', name: 'info', component: UserInfo },
      { path: 'info-edit', name: 'info-edit', component: UserInfoEdit },
      { path: 'change-password', name: 'change-password', component: ChangePassword },
      { path: 'test', name: 'test', component: Test },
      { path: 'test-form-validate', name: 'test-form-validate', component: TestFormValidate },
      {
        path: 'user',
        name: 'user',
        component: User,
        redirect: { name: 'user-list' },
        children: [
          { path: 'list', name: 'user-list', component: UserList },
          { path: 'create', name: 'user-create', component: UserCreate },
          { path: 'edit/:id', name: 'user-edit', component: UserEdit },
          { path: 'request', name: 'user-request', component: UserRequest },
          { path: 'reset-password', name: 'user-reset-password', component: UserResetPassword },
        ]
      },
      {
        path: 'department',
        name: 'department',
        component: Department,
        redirect: { name: 'department-list' },
        children: [
          { path: 'list', name: 'department-list', component: DepartmentList },
          { path: 'create', name: 'department-create', component: DepartmentCreate },
          { path: 'edit/:id', name: 'department-edit', component: DepartmentEdit }
        ]
      },
      { path: 'check-in', name: 'check-in', component: CheckInOut },
      { 
        path: 'request', 
        name: 'request', 
        component: Request,
        children: [
          { path: 'create', name: 'request-create', component: RequestCreate },
          { path: 'list', name: 'request-list', component: RequestList },
        ]
      },
      {
        path: 'manager',
        name: 'manager',
        component: Manager,
        children: [
          { path: 'department', name: 'manager-department', component: ManagerDepartment },
          { path: 'request', name: 'manager-request', component: ManagerRequest },
        ]
      },
      {
        path: 'error',
        name: 'error',
        component: Error,
        children: [
          { path: '401', name: 'error-401', component: Error401 },
          { path: '404', name: 'error-404', component: Error404 },
        ]
      },
      { path: '*', redirect: {name: 'error-404'} }
    ]
  },
];

const router = new VueRouter({
  mode: 'history',
  routes
});

router.beforeEach(async (to, from, next) => {
  const name = to.name;
  if (name.indexOf('user') === -1 && name.indexOf('department') === -1 && name.indexOf('manager') === -1) {
    next();
  } else {
    let user = await me();
    if (user.role_id === 1) {
      next();
    } else if (user.role_id === 2 && name.indexOf('manager') !== -1) {
      next();
    } else {
      next({name: 'error-401'});
    }
  }
});

export default router;