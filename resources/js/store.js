import router from './routes';
import Vuex from 'vuex';
import {getLocalUser, getLocalToken} from "./utilities/Auth";

const user = getLocalUser();
const token = getLocalToken();

let storeData = {
    state: {
        user: user,
        token: token,
        intendedUrl: null,
        isBlockedRoute: false,
        flash: {
            activated: false,
            message: null,
            type: null
        }
    },

    getters: {

    },

    mutations: {
        SET_USER(state, data) {
            state.user = data;

            localStorage.setItem("user", JSON.stringify(state.user));
        },

        SET_TOKEN(state, data){
            state.token = data;

            localStorage.setItem("token", JSON.stringify(state.token));
        },

        SET_INTENDED_URL(state, data) {
            state.intendedUrl = data;
        },

        SET_IS_ROUTE_BLOCKED(state, data) {
            state.isBlockedRoute = data;
        },

        SET_POPED(state, data) {
            state.poped[data.name] = data.activated;
        },

        SET_FLASH(state, data) {
            if(!data.type)
                data.type = null;
            
            state.flash = data;
        }
    },

    actions: {
        logout(context){
            context.commit("SET_USER",null);

            context.commit("SET_TOKEN", null);

            localStorage.removeItem("user");

            localStorage.removeItem("token");

            router.push('/login');
        },

        pop(context, data){
            let requiredBlack = false;

            context.commit("SET_POPED", data);

            for(let prop in context.state.poped) {
                if(context.state.poped[prop])
                    requiredBlack = true;
            }

            context.commit("SET_REQUIRED_BLACK", requiredBlack);
            },

    }
}

export default new Vuex.Store(storeData);
