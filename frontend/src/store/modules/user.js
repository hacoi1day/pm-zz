const state = {
  userInfo: null
};

const mutations = {
  setUser (state, userInfo) {
    state.userInfo = userInfo;
  },
  clearUser(state) {
    state.userInfo = null;
  }
};

export default {
  state,
  mutations
};
