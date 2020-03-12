import axios from 'axios';

export const state = {
    user: null
};

// getters
export const getters = {
    user: state => state.user,
    check: state => state.user !== null
};

// mutations
export const mutations = {
    SaveUser(state, {user}) {
        state.user = user;
    },

    Logout(state) {
        state.user = null;
    }
};

// actions
export const actions = {

    Authenticate({commit, dispatch}, payload) {
        commit('SaveUser', payload);
    },

    async FetchUser({commit}) {
        await axios.get('/api/user')
            .then(response => {
                commit('SaveUser', {user: response.data.data});
            });
    },
    logout({commit}) {
        return axios.post('/api/logout').then(() => {
            commit('Logout');

            return true;
        });
    }

};
