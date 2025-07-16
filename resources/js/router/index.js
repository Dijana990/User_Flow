import { createRouter, createWebHistory } from 'vue-router'
import LoginComponent      from '../Components/LoginComponent.vue'
import RegisterComponent   from '../Components/RegisterComponent.vue'
import DashboardComponent  from '../Components/DashboardComponent.vue'
import AdminDashboard      from '../Components/AdminDashboard.vue'

const routes = [
  { path: '/', redirect: '/login' },
  { path: '/login',     component: LoginComponent,    meta: { guest: true } },
  { path: '/register',  component: RegisterComponent, meta: { guest: true } },
  { path: '/dashboard', component: DashboardComponent, meta: { requiresAuth: true } },
  { path: '/admin',     component: AdminDashboard,    meta: { requiresAuth: true, requiresAdmin: true } },
  { path: '/:pathMatch(.*)*', redirect: '/login' },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, _from, next) => {
  const token = localStorage.getItem('token')
  const userStr = localStorage.getItem('user')
  const user = userStr ? JSON.parse(userStr) : {}

  const isLoggedIn = !!token

  if (to.meta.requiresAuth && !isLoggedIn) {
    return next('/login')
  }

  if (to.meta.guest && isLoggedIn) {
    if (user.role === 'admin') {
      return next('/admin')
    } 
    return next('/dashboard')
  }

  if (to.meta.requiresAdmin && (!user.role || user.role !== 'admin')) {
    return next('/dashboard')
  }

  next()
})

export default router
