import Vue from 'vue'
import Router from 'vue-router'
import Main from '@/components/Main'
import Home from '@/components/Home'
import Login from '@/components/Login'
import Category from '@/components/Category'

Vue.use(Router)

export default new Router({
  mode: 'history',
  linkActiveClass: 'active',
  routes: [
    {
      path: '/',
      component: Main,
      children: [
        {name: 'home', path: '', component: Home},
        {name: 'category', path: 'category', component: Category},
        {name: 'login', path: 'login', component: Login}
      ]
    }
  ]
})
