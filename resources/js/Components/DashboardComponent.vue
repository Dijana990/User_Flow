<template>
  <div class="admin-dashboard">
    <div class="header">
      <h1>Admin Dashboard</h1>
      <button @click="logout" class="logout-btn">Logout</button>
    </div>

    <section class="widgets">
      <div class="widget">
        <h3>Total Users</h3>
        <p class="value">{{ users }}</p>
      </div>
      <div class="widget">
        <h3>Total Admins</h3>
        <p class="value">{{ admins }}</p>
      </div>
    </section>

    <UserList @edit-user="editUser" @refresh="fetchUsers" ref="userList" />

    <UserForm
      v-if="showForm"
      :user="selectedUser"
      @close="closeForm"
      @refresh="refreshAfterSubmit"
    />
  </div>
</template>

<script>
import axios from 'axios'
import UserList from './UserList.vue'
import UserForm from './UserForm.vue'
import { auth } from '../store/auth.js'

export default {
  components: { UserList, UserForm },
  data() {
    return {
      showForm: false,
      selectedUser: null,
      users: 0,
      admins: 0,
      userRole: '', // dodano
    }
  },
  async mounted() {
    try {
      const token = localStorage.getItem('token')
      const headers = { Authorization: `Bearer ${token}` }
      const response = await axios.get('/api/user', { headers })
      this.userRole = response.data.role
      await this.refreshStats()
    } catch (error) {
      console.error('Failed to fetch user info:', error)
    }
  },
  methods: {
    async refreshStats() {
      try {
        if (this.userRole !== 'admin') {
          this.users = 0
          this.admins = 0
          return
        }

        const token = localStorage.getItem('token')
        const headers = { Authorization: `Bearer ${token}` }

        const userCount = await axios.get('/api/users/count', { headers })
        const adminCount = await axios.get('/api/users/admins/count', { headers })

        this.users = userCount.data.count
        this.admins = adminCount.data.count
      } catch (error) {
        console.error('Error retrieving statistics:', error)
        this.users = 0
        this.admins = 0
      }
    },
    editUser(user) {
      this.selectedUser = user
      this.showForm = true
    },
    closeForm() {
      this.showForm = false
      this.selectedUser = null
    },
    fetchUsers() {
      this.$refs.userList.fetchUsers()
    },
    refreshAfterSubmit() {
      this.closeForm()
      this.fetchUsers()
      this.refreshStats()  // opcionalno da se osvježe brojevi nakon izmjene
    },
    logout() {
      auth.logout()
      this.$router.push('/login')
    },
  }
}
</script>

<style lang="scss" scoped>
@use '../style/admin.scss' as *;
</style>
