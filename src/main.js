import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import App from './App.vue'
import Sdt from './components/Student.vue'
import New from './components/New.vue'
import NewSdt from './components/NewSdt.vue'
import NewProf from './components/NewProf.vue'
import Session from './components/Session.vue'
import Prof from './components/Prof.vue'
import PagePdf from './components/PagePdf.vue'

const app = createApp(App)

const routes = [  
    {path: '/', component: New},
    {path: '/sdt', component: Sdt},
    {path: '/session', component: Session},
    {path: '/prof', component: Prof},
    {path: '/new', component: New},
    {path: '/newSdt', component: NewSdt},
    {path: '/newProf', component: NewProf},
    {path: '/pagePdf', component: PagePdf}
]

const router  = createRouter({
    history:createWebHistory(),
    routes
})

app.use(router)
app.mount('#app')

