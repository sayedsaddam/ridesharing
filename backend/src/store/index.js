import { createStore } from "vuex"
import state from './state'
import * as actions from './actions'
import * as mutations from './mutations'

const store = createStore({
    state,
    // state: {
    //     user: {
    //         token: '1234',
    //         data: {}
    //     }
    // },
    getters: {},
    actions: {},
    mutations: {}
})

export default store
