import axios from 'axios';

export const state = {
    contacts: [],
    requested: [],
    excepted: []
};

// getters
export const getters = {
    contacts: state => state.contacts,
    requested: state => state.requested,
    excepted: state => state.excepted
};

// mutations
export const mutations = {
    setContacts(state, {contacts}) {
        state.contacts = contacts;
    },
    setRequested(state, {requested}) {
        state.requested = requested;
    },
    setExcepted(state, {excepted}) {
        state.excepted = excepted;
    },

    addContact(state, {contact}) {
        state.excepted = _.filter(state.excepted, user => {
            user.id == contact.id;
        });

        state.requested = _.filter(state.requested, user => {
            user.id == contact.id;
        });

        state.contacts.push(contact);
    },
    addRequested(state, {contact}) {
        state.requested.push(contact);
    },
    addExcepted(state, {contact}) {
        state.excepted.push(contact);
    }
};

// actions
export const actions = {
    async getContacts({commit}) {
        await axios.get('/api/contacts')
            .then(response => {
                commit('setContacts', {contacts: response.data.data});
                commit('setRequested', {requested: response.data.requested});
            });
    },
    async getExcepted({commit}) {
        await axios.get('/api/contacts/excepted')
            .then(response => {
                commit('setExcepted', {excepted: response.data.data});
            });
    }

};
