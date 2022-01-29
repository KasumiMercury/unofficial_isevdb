import Router from 'vue-router'
import Player from './views/Player.vue'
import topPlayer from './views/topPlayer.vue'
import Category from './views/Category.vue'
import NotFound from './views/NotFound.vue'
import Home from './views/home.vue'
import PlayerList from './views/PlayerList.vue'
import Add from './views/add.vue'

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const scrollBehavior = (to, from, savedPosition) => {
  if (savedPosition) {
    return savedPosition;
  } else {
    return { x: 0, y: 0 }
  }
};

export default new Router({
  mode: 'history',
  scrollBehavior,
  routes: [
    {
      path: '*',
      name: 'notfound',
      component: NotFound
    },   
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/top/player/:id',
      name: 'TopPlayer',
      component: topPlayer
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
      path: '/:member/player/:id',
      name: 'player',
      component: Player
    },
  ]
});