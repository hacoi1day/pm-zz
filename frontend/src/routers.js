import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

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

// import { me } from './apis/auth';

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
    children: [
      { path: 'user-info', name: 'user-info', component: UserInfo },
      { path: 'user-info-edit', name: 'user-info-edit', component: UserInfoEdit },
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
      }
    ]
  },
  
];

const router = new VueRouter({
  mode: 'history',
  routes
});

// router.beforeEach(async (to, from, next) => {
//   if (to.next === 'login' || to.name === 'reset-password') {
//     return next();
//   } else {
//     const res = await me();
//     if (res) {
//       return next();
//     } else {
//       return next({name: 'login'});
//     }
//   }
// });

export default router;