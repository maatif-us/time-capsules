import './bootstrap';
import '../sass/app.scss'
import Router from '@/router'
import store from '@/store'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'





import { createApp } from 'vue/dist/vue.esm-bundler';

const app = createApp({})

// app.config.globalProperties.$moment = useMoment();
// app.config.globalProperties.$moment = moment;
app.use(ElementPlus)

app.use(Router)
app.use(store)
app.mount('#app')