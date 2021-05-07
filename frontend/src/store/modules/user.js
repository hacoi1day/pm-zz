const state = {
  userInfo: null
};

const mutations = {
  setUser (state, userInfo) {
    state.userInfo = userInfo;
  },
  clearChangePassword (state) {
    state.userInfo.change_password = [];
  },
  clearUser(state) {
    state.userInfo = null;
  }
};

export default {
  state,
  mutations
};
