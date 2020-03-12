import store from '~client/store';

export default async (to, from, next) => {
    if (store.getters['auth/user']) {
        return next({name: 'home'});
    }

    return next();
}
