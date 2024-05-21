// store/index.js

import { createStore } from 'vuex';

export default createStore({
  state: {
    token: null,
  },
  mutations: {
    setToken(state, token) {
      state.token = token;
    },
    clearToken(state) {
      state.token = null;
    },
  },
  actions: {
    login({ commit }, token) {
      commit('setToken', token);
    },
    logout({ commit }) {
      commit('clearToken');
      // You may also want to clear other state related to the user
    },
  },
  getters: {
    isAuthenticated(state) {
      return !!state.token;
    },
  },
});
