import axios from 'axios'
import router from '@/router'

export default {
    namespaced: true,
    state:{
        authenticated: false,
        user: {},
        validationErrors: {},
        processing: false,
        accessToken: null,
    },
    getters:{
        isAuthenticated: state => state.authenticated,
        user: state => state.user,
        validationErrors: state => state.validationErrors,
        processing: state => state.processing,
        accessToken: state => state.accessToken,
    },
    mutations:{
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value;
          },
          SET_USER(state, user) {
            state.user = user;
          },
          SET_VALIDATION_ERRORS(state, errors) {
            state.validationErrors = errors;
          },
          SET_PROCESSING(state, value) {
            state.processing = value;
          },
          SET_ACCESS_TOKEN(state, token) {
            state.accessToken = token;
          },
    },
    actions:{
        async login({ commit }, credentials) {
            commit('SET_PROCESSING', true);
            try {
              const response = await axios.post('api/login', credentials);
              const { user, token } = response.data;
              commit('SET_USER', user);
              commit('SET_ACCESS_TOKEN', token.accessToken);
              commit('SET_AUTHENTICATED', true);
              router.push({ name: 'capsules' });
            } catch (error) {
              if (error.response.status === 422) {
                commit('SET_VALIDATION_ERRORS', error.response.data.errors);
              } else {
                commit('SET_VALIDATION_ERRORS', error.response.data);
              }
              throw error.response.data;
            } finally {
              commit('SET_PROCESSING', false);
            }
          },

          async register({ commit }, data) {
            commit('SET_PROCESSING', true);
            try {
              await axios.post('api/register', data);
              router.push({ name: 'login' });
            } catch (error) {
              if (error.response.status === 422) {
                commit('SET_VALIDATION_ERRORS', error.response.data.errors);
              } else {
                commit('SET_VALIDATION_ERRORS', error.response.data);
              }
              commit('SET_PROCESSING', false);
              throw error.response.data;
            }
          },
        async logout({commit}){
            commit('SET_USER',{})
            commit('SET_AUTHENTICATED',false)
        }
    }
}