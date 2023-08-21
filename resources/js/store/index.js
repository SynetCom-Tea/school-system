
import { authPageModule } from './auth-store/index.js';
import { createStore } from "vuex";
export const store =  createStore({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        authPageModule,
    }
});