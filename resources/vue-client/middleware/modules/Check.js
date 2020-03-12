import store from '~client/store';

export default async (to, from, next) => {
    if (!store.getters['auth/user']) {
        try {
            await store.dispatch('auth/FetchUser');
            if (to.name !== 'login' && to.name !== 'password.reset') {
                return next();
            } else {
                return next({name: 'home'});
            }
        } catch (e) {

        }
    }

    return next();
}
