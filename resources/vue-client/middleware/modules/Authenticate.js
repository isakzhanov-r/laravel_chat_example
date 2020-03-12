import store from '~client/store';

export default async (to, from, next) => {
    if (!store.getters['auth/user']) {
        try {
            await store.dispatch('auth/FetchUser');
            return next();
        } catch (e) {
            return next({name: 'login'});
        }
    }

    return next();
}
