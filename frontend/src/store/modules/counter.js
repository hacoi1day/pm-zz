const state = {
  count: 0
};

const mutations = {
  increment(state) {
    state.count++;
  },
  decrement(state) {
    state.count--;
  },
  change(state, value) {
    state.count = value;
  }
};

export default {
  state,
  mutations
};
