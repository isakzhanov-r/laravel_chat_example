import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const requireModules = require.context('./modules', false, /.*\.js$/);

const modules = requireModules.keys()
    .map(file =>
        [file.replace(/(^.\/)|(\.js$)/g, ''), requireModules(file)]
    )
    .reduce((modules, [name, module]) => {
        if (module.namespaced === undefined) {
            module.namespaced = true;
        }

        return {...modules, [name]: module};
    }, {});

export default new Vuex.Store({modules});
