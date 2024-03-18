import apiRequest from '../interceptor/api';
import { formatDate } from '../utils/dateTime';

export default {
  namespaced: true,
  state: {
    errorMessage: '',
    capsules: [],
    editCapsule: null,
    isLoading: false,
    pagination: {
      count: 0,
      currentPage: 1,
      firstItem: 1,
      hasMorePages: true,
      lastItem: 1,
      lastPage: 1,
      nextPageUrl: "",
      page: "1",
      perPage: 10,
      previousPageUrl: null,
      total: 10,
      url: ""
    },
    searchQuery: '',
    dateTimeQuery: '',
    startDate: '',
    endDate: '',
    
  },
  getters: {
    pagination: state => state.pagination,
    total: (state) => state.pagination,
    isLoading: state => state.isLoading,
    capsules: (state) => state.capsules,
    searchQuery: (state) => state.searchQuery,
    dateTimeQuery: (state) => state.dateTimeQuery,
    editCapsule: (state) => state.editCapsule,
    errorMessage: (state) => state.errorMessage,
    startDate: (state) => state.startDate,
    endDate: (state) => state.endDate,
  },
  mutations: {
    SET_CAPSULES(state, capsules) {
      state.capsules = capsules;
    },
    ADD_CAPSULE(state, capsule) {
      state.capsules.push(capsule);
    },
    UPDATE_CAPSULE(state, updatedCapsule) {
        const index = state.capsules.findIndex(c => c.id === updatedCapsule.id);
        if (index !== -1) {
          state.capsules.splice(index, 1, updatedCapsule);
        }
    },
    SET_EDIT_CAPSULE(state, capsule) {
      state.editCapsule = capsule;
    },
    SET_CURRENT_PAGE(state, currentPage) {
      state.pagination.currentPage = currentPage;
    },
    SET_PER_PAGE(state, perPage) {
      state.pagination.perPage = perPage;
    },
    UPDATE_PAGINATION(state, paginationData) {
      state.pagination = {...paginationData};
    },
    SET_SEARCH_QUERY(state, query) {
      state.searchQuery = query;
    },
    SET_DATETIME_QUERY(state, dateTime) {
      state.dateTimeQuery = dateTime;
    },
    SET_LOADING(state, isLoading) {
      state.isLoading = isLoading;
    },
    SET_ERROR_MESSAGE(state, error) {
      if (typeof error === 'object') {
        return state.errorMessage = error.join(', ');
      }
      state.errorMessage = error;
    },
    SET_START_DATE(state, startDate) {
      state.startDate = startDate;
    },
    SET_END_DATE(state, endDate) {
      state.endDate = endDate;
    },
    REMOVE_CAPSULE(state, capsuleId) {
      state.capsules = state.capsules.filter(capsule => capsule.id !== capsuleId);
   },
   RESET_FORM(state) {
      state.editCapsule = null;
      state.errorMessage = '';
      state.isLoading = false;
   }
  },
  actions: {
    async fetchCapsules({ commit, state }) {
      try {
        commit('SET_LOADING', true);
        const response = await apiRequest.get(`capsule/all?page=${state.pagination.currentPage}&perPage=${state.pagination.perPage}&searchQuery=${state.searchQuery}&startDate=${state.startDate}&endDate=${state.endDate}`);
        commit('SET_LOADING', false);
        const capsules = response.data;
        commit('UPDATE_PAGINATION', capsules.meta.pagination);
        commit('SET_CAPSULES', capsules.data);
      } catch (error) {
        // commit('SET_ERROR_MESSAGE', error.response.data.error)
        throw error;
      }
    },
    async deleteCapsule({ commit }, capsuleId) {
      try {
        commit('SET_LOADING', true);
        await apiRequest.delete(`capsule/${capsuleId}`);
        commit('SET_LOADING', false);
        commit('REMOVE_CAPSULE', capsuleId);
      } catch (error) {
        // commit('SET_ERROR_MESSAGE', error.response.data.error)
        throw error;
      }
   },
    async createCapsule({ commit }, capsule) {
      try {
        commit('SET_LOADING', true);
        const response = await apiRequest.post('capsule/store', capsule);
        commit('ADD_CAPSULE', response.data.data);
        commit('SET_LOADING', false);
      } catch (error) {
        // commit('SET_ERROR_MESSAGE', error.response.data.error)
        throw error;
        commit('SET_LOADING', false);
      }
    },
    async updateCapsule({ commit }, updatedCapsule) {
        try {
          commit('SET_LOADING', true);
          const response = await apiRequest.patch(`capsule/update/${updatedCapsule.id}`, updatedCapsule);
          commit('SET_LOADING', false);
          commit('SET_EDIT_CAPSULE', null);
          commit('UPDATE_CAPSULE', response.data.data);
        } catch (error) {
          // commit('SET_ERROR_MESSAGE', error.response.data.error)
        throw error;
          commit('SET_LOADING', false);
        }
    },
    async fetchCapsuleById({ commit }, capsuleId) {
      try {
        const response = await apiRequest.get(`capsule/view/${capsuleId}`);
        const capsule = response.data;
        // Commit mutation to update the state with the fetched capsule
        commit('UPDATE_CAPSULE', capsule.data);
        commit('SET_EDIT_CAPSULE', capsule.data);
      } catch (error) {
        // commit('SET_ERROR_MESSAGE', error.response.data.error)
        throw error;
        console.error('Error fetching capsule:', error);
      }
    },
    setCurrentPage({ commit }, currentPage) {
      commit('SET_CURRENT_PAGE', currentPage);
    },
    setPerPage({ commit }, perPage) {
      commit('SET_PER_PAGE', perPage);
    },
    setSearchQuery({ commit }, query) {
      commit('SET_SEARCH_QUERY', query);
    },
    setDateTimeQuery({ commit }, dateTime) {
      commit('SET_DATETIME_QUERY', dateTime);
    },
    resethForm({commit}) {
      commit('RESET_FORM');
    },
    async setStartEndDate({ commit }, startDateEndDate) {
      try {
        const [startDate, endDate] = startDateEndDate;
        commit('SET_START_DATE', formatDate(startDate));
        commit('SET_END_DATE', formatDate(endDate));
      } catch (error) {
        commit('SET_START_DATE', '');
        commit('SET_END_DATE', '');
      }
    },
  }
};
