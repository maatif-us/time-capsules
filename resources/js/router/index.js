import { createWebHistory, createRouter } from 'vue-router'
import store from '@/store'
const Login = () => import('@/Pages/Login/Login.vue')
const Register = () => import('@/Pages/Register/Register.vue')
const DahboardLayout = () => import('@/components/Layouts/MainLayout.vue')
const Capsules = () => import('@/Pages/Capsule/Capsules.vue');
const CapsuleForm = () => import('@/Pages/Capsule/Form.vue');
const DetailView = () => import('@/Pages/Capsule/Detail.vue');


const routes = [
    {
        name: "login",
        path: "/login",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        name: "register",
        path: "/register",
        component: Register,
        meta: {
            middleware: "guest",
            title: `Register`
        }
    },
    {
        path: "/",
        component: DahboardLayout,
        meta: {
            middleware: "auth"
        },
        name: "home",
        redirect: '/capsules',
        children: [
            {
                name: "capsules",
                path: '/capsules',
                component: Capsules,
                meta: {
                    title: `Capsules`
                },
            },
            {
                        
                name: "create",
                path: '/create',
                component: CapsuleForm,
                meta: {
                    title: `Capsule - Create`
                },
            },
            {
                        
                name: "view",
                path: '/capsules/:id/view',
                component: DetailView,
                meta: {
                    title: `Capsule - View`
                },
            },
            {
                name: "edit",
                path: '/capsules/:id/edit',
                component: CapsuleForm,
                meta: {
                   title: `Capsule - Edit`
                },
            }
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "capsules" })
        }
        next()
    } else {
        if (store.state.auth.authenticated) {
            next()
        } else {
            next({ name: "login" })
        }
    }
})

export default router