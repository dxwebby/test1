
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

// Modules
import todo from './modules/todo.js';
export default new Vuex.Store({
    modules:{
        todo,
    }
})