import Index from '../components/pages/Index';

const Login = () => import('~client/pages/auth/Login').then(m => m.default || m);
const Register = () => import('~client/pages/auth/Register').then(m => m.default || m);
const ResetPassword = () => import('~client/pages/auth/ResetPassword').then(m => m.default || m);
const ConfirmPassword = () => import('~client/pages/auth/ConfirmPassword').then(m => m.default || m);

const Home = () => import( '~client/pages/Home').then(m => m.default || m);
const Profile = () => import( '~client/pages/user/Profile').then(m => m.default || m);


export default [
    {
        path: '/home', component: Index, meta: {middleware: 'auth', icon: 'mdi mdi-view-dashboard', title: 'Консоль'}, children: [
            {name: 'home', path: '', component: Home, meta: {title: 'Главная'}}
        ]
    },
    {
        path: '/user', component: Index, meta: {middleware: 'auth', icon: 'mdi-account-multiple', title: 'Пользователи'}, children: [
            {name: 'profile', path: '', component: Profile, meta: {title: 'Профиль', is_show: false}}
        ]
    },
    {path: '/', redirect: {name: 'home'}},
    {
        name: 'login', path: '/login', component: Login,
        meta: {middleware: ['guest', 'check'], title: 'Авторизация', is_show: false}
    },
    {
        name: 'register', path: '/register', component: Register,
        meta: {middleware: ['guest', 'check'], title: 'Авторизация', is_show: false}
    },
    {
        name: 'password.reset', path: '/password/reset/:token', component: ResetPassword,
        meta: {middleware: ['guest', 'check'], title: 'Сбросс пароля', is_show: false}
    },
    {
        name: 'password.confirm', path: '/password/confirm', component: ConfirmPassword,
        meta: {middleware: 'guest', title: 'Подтверждение регистрации', is_show: false}
    }
];
