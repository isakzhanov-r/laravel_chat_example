import Vue from 'vue';
import Vuetify from 'vuetify';
import store from './store/index';
import router from './routes/index';
import DatetimePicker from 'vuetify-datetime-picker';
import Echo from 'laravel-echo';
import axios from 'axios';
import App from './components/App';

window.io = require('socket.io-client');
const vuetifyOptions = {
    theme: {
        dark: true,
        primary: '#039BE5',
        secondary: '#0288D1',
        accent: '#0277BD',
        error: '#E53935',
        warning: '#FFA000',
        info: '#2196F3',
        success: '#4CAF50'
    }
};

Vue.use(Vuetify);
Vue.use(DatetimePicker);
Vue.use(require('vue-moment'));

Vue.prototype.$axios = axios;
Vue.prototype.$axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Vue.prototype.$axios.defaults.headers.get['Content-Type'] = 'application/json';
Vue.prototype.$axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
Vue.prototype.$axios.defaults.headers.patch['Content-Type'] = 'application/x-www-form-urlencoded';
Vue.prototype.$axios.defaults.headers.delete['Content-Type'] = 'application/json';

Vue.prototype.$echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

Vue.prototype.$eventHub = new Vue();

new Vue({
    store,
    router,
    vuetify: new Vuetify(vuetifyOptions),
    ...App
}).$mount('#app');
