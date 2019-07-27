import axios from 'axios';
import store from '../store';
import router from '../routes';

export default function setup() {
    axios.interceptors.request.use((config) => {
        const token = store.state.token;

        if(token) {
            config.headers.Authorization = `${token.token_type} ${token.access_token}`;
        }
        return config;
    }, (error) => {
        return Promise.reject(error);
    });

    axios.interceptors.response.use((response) => {
        return response;
    }, (error) => {
        if(error.response.data.message !== undefined){
            if(error.response.data.message.includes('Unauthenticated')) {
                store.commit('SET_INTENDED_URL', router.currentRoute.path);
                store.commit('SET_IS_ROUTE_BLOCKED', true);

                store.dispatch('logout');

                router.push('/login');
            }

            // 토큰만료시 로그아웃
            if(error.response.data.message === 'Token is Expired') {
                store.commit('SET_INTENDED_URL', router.currentRoute.path);
                store.commit('SET_IS_ROUTE_BLOCKED', true);

                store.dispatch('logout');

                router.push('/login');
            }
        }



        return Promise.reject(error);
    });
}
