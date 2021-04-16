import Vue from 'vue';
import Vuex from 'vuex';

import user from './modules/user';
import counter from './modules/counter';
import token from './modules/token';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    user,
    counter,
    token
  }
});

export default store;
