import Vue from 'vue';
import VRouter from 'vue-router';
import Meta from 'vue-meta';
import store from './../store';
import web from './web';
import {sync} from 'vuex-router-sync';
import MiddlewareClass from '../middleware/MiddlewareClass';

Vue.use(VRouter);
Vue.use(Meta);

let document_title = 'Static Hyundai АВАНГАРД | ';

const router = new VRouter({
    mode: 'history',
    routes: web
});

router.beforeEach(beforeEach);
router.afterEach(afterEach);

async function beforeEach(to, from, next) {
    const Middleware = new MiddlewareClass();

    let middleware = [];

    to.matched.forEach(match => {
        if ('middleware' in match.meta) {
            if (typeof match.meta.middleware === 'object') {
                match.meta.middleware.forEach(value =>{
                    middleware.push(value);
                })
            } else {
                middleware.push(match.meta.middleware);
            }
        }
    });
    Middleware.use(middleware).callMiddleware(to, from, (...args) => {
        if (args.length > 0) {

        }

        next(...args);
    });
}

async function afterEach(to, from, next) {
    const Middleware = new MiddlewareClass();


    await router.app.$nextTick(() => {
        document.title = to.meta.title ? document_title + to.meta.title : document_title;
    });
}

export default router;
sync(store, router);
