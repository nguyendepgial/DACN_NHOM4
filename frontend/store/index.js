import Cookies from 'js-cookie';

export const state = () => ({
  cart: [],
  user: null
});

export const mutations = {
  setCart(state, cart) {
    state.cart = cart;
  },
  setUser(state, user) {
    state.user = user;
  },
  clearUser(state) {
    state.user = null;
  }
};

export const actions = {
  nuxtServerInit({ commit }) {
    if (process.client) {
      const user = Cookies.get('user');
      if (user) {
        commit('setUser', JSON.parse(user));
      }
    }
  },
  fetchCart({ commit }) {
    const cart = []; // Replace with actual fetch logic
    commit('setCart', cart);
  },
  fetchUser({ commit }) {
    const user = { isLoggedIn: true, email: 'user@example.com' }; // Replace with actual fetch logic
    commit('setUser', user);
  },
  logout({ commit }) {
    if (process.client) {
      Cookies.remove('user');
    }
    commit('clearUser');
  }
};

export const getters = {
  isLoggedIn: state => !!state.user,
  userEmail: state => state.user ? state.user.email : ''
};
