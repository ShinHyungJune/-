import VueRouter from 'vue-router';
import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import SendPasswordResetMail from './pages/SendPasswordResetMail';
import PasswordReset from './pages/PasswordReset';
import store from './store';

let routes = [
    {
        path: '/login',
        component: Login,
        pageName: "로그인",
        beforeEnter(to, from, next){
            if(store.state.user)
                return next('/');
        }
    },

    {
        path: '/register',
        component: Register,
        pageName: "회원가입",
        beforeEnter(to, from, next){
            if(store.state.user)
                return next('/');
        }
    },

    {
        path: '/passwordReset',
        component: SendPasswordResetMail,
        pageName: "비밀번호 재설정",
        beforeEnter(to, from, next){
            if(store.state.user)
                return next('/');
        }
    },

    {
        path: '/passwordReset/:token',
        component: PasswordReset,
        pageName: "비밀번호 재설정",
        beforeEnter(to, from, next){
            if(store.state.user)
                return next('/');
        }
    }

];

export default new VueRouter({
    mode: 'history',
    routes
});
