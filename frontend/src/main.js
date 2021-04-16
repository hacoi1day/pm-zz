import Vue from 'vue';
import router from './routers';

import './configs/bootstrap';
import './configs/notification';
import './configs/fontawesome';
import './configs/processbar';
import './configs/vCalendar';

import App from './App.vue';
import './App.scss';

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
