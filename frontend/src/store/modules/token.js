const state = {
  value: null
};

const mutations = {
  setToken (state, value) {
    state.value = value;
  },
  clearToken(state) {
    state.userInfo = null;
  }
};

export default {
  state,
  mutations
};
