import axios from 'axios';

export const state = {
    messages: [],
    not_read_messages: []
};

// getters
export const getters = {
    messages: state => state.messages,
    not_read_messages: state => state.not_read_messages
};

// mutations
export const mutations = {
    setMessages(state, {messages}) {
        state.messages = messages;
    },

    setNotReadMessages(state, {messages}) {
        state.not_read_messages = messages;
    },

    addMessages(state, {message}) {
        if (!message.is_read) {
            state.not_read_messages.push(message);
        }
        state.messages.push(message);
    }
};

// actions
export const actions = {
    getMessages({commit}, payload = {}) {
        axios.get('/api/to/' + payload.contact.id + '/messages')
            .then(response => {
                commit('setMessages', {messages: response.data.data});
            });
    },

    getNotReadMessages({commit}){
        axios.get('/api/messages/not-read')
            .then(response => {
                commit('setNotReadMessages', {messages: response.data.data});
            });
    }
};
