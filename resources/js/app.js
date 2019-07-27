import './bootstrap';
import Vue from 'vue';
import router from './routes';
import store from './store';

/* utils */
import setUpInterceptor from './utilities/Interceptors'; // 토큰부착 및 리프레쉬

/* mixins */
import collection from './mixins/Collection';
import pop from './mixins/Pop';

import Pop from './components/common/Pop';
import Flash from './components/common/Flash';

Vue.component('pop', Pop);
Vue.component('flash', Flash);

Vue.mixin(collection);
Vue.mixin(pop);

setUpInterceptor();

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    const user = store.state.user;

    // 인증필요여부
    if(requiresAuth && !user){
        store.commit('SET_INTENDED_URL', to.path);

        store.commit('SET_IS_ROUTE_BLOCKED', true);

        next('/login');
    }

    return next();

});

const app = new Vue({
    el: '#app',

    router,

    store,

    computed: {
        flashActivated(){
            return store.state.flash.activated;
        }
    }
});
