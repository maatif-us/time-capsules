import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from '@/store/auth'
import capsule from '@/store/capsule'

const store = createStore({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
        capsule
    }
})

export default store