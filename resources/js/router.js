import Router from 'vue-router'
import Player from './views/Player.vue'
import Category from './views/Category.vue'
import NotFound from './views/NotFound.vue'
import Home from './views/home.vue'
import PlayerList from './views/PlayerList.vue'
import Add from './views/add.vue'

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)


export default new Router({
  mode: 'history',
  routes: [
    {
      path: '*',
      name: 'notfound',
      component: NotFound
    },   
    {
      path: '/:member/add',
      name: 'add',
      component: Add
    },
    {
      path: '/:member/:cate',
      name: 'Category',
      component: Category,
      children: [
        { path: '', component: PlayerList }
      ]
    },
    {
      path: '/',
      name: 'home',
      component: Home
    },   
    {
      path: '/:member/player/:id',
      name: 'player',
      component: Player
    },
  ]
});