import { createRouter, createWebHistory } from 'vue-router'
import LoginPage from '../components/LoginPage.vue'
import RegisterPage from '../components/RegisterPage.vue'
import MainPage from '../components/MainPage.vue'

const routes = [
  { path: '/login', name: 'Login', component: LoginPage },
  { path: '/register', name: 'Register', component: RegisterPage },
  { path: '/main', name: 'Main', component: MainPage, meta: { requiresAuth: true }, },
  { path: '/', redirect: '/login' },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Mock authentication check for route guarding
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('auth') // Replace with real auth check

  if (to.name === '' && !isAuthenticated) {
  // if (!isAuthenticated) {
    next({ name: 'Login' })
  } else {
    next()
  }
})

export default router
