<template>
  <div class="dashboard">
    <div class="main-content">
      <header class="header">
        <h1>Welcome, {{ userName }}</h1>
        <button @click="logout" aria-label="Logout" class="btn-logout">Logout</button>
      </header>

      <section class="widgets">
        <div class="widget">
          <h3>Total Users</h3>
          <p class="value">{{ users }}</p>
        </div>
        <div class="widget">
          <h3>Admins</h3>
          <p class="value">{{ admins }}</p>
        </div>
      </section>

      <UserList @refresh-stats="refreshStats" />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import UserList from './UserList.vue'

export default {
  components: { UserList },
  data() {
    return {
      userName: '',
      users: 0,
      admins: 0,
    }
  },
  async mounted() {
    await this.refreshStats()
    const token = localStorage.getItem('token')
    try {
      const userResponse = await axios.get('/api/user', { headers: { Authorization: `Bearer ${token}` } })
      this.userName = userResponse.data.name
    } catch (error) {
      console.error('Error retrieving user:', error)
    }
  },
  methods: {
    async refreshStats() {
      try {
        const token = localStorage.getItem('token')
        const headers = { Authorization: `Bearer ${token}` }

        const userCount = await axios.get('/api/users/count', { headers })
        const adminCount = await axios.get('/api/users/admins/count', { headers })

        this.users = userCount.data.users
        this.admins = adminCount.data.admins
      } catch (error) {
        console.error('Error retrieving statistics:', error)
      }
    },
    logout() {
      localStorage.removeItem('token')
      this.$router.push('/login')
    },
  },
}
</script>

<style lang="scss" scoped>
@use '../style/dashboard.scss' as *;
</style>
