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
      userRole: '',      
      userName: '',      
    }
  },
  async mounted() {
    try {
      const token = auth.getToken()
      if (!token) {
        this.$router.push('/login')
        return
      }

      const response = await axios.get('/api/user', {
        headers: { Authorization: `Bearer ${token}` }
      })

      this.userRole = response.data.role
      this.userName = response.data.name

      await this.refreshStats()
    } catch (error) {
      console.error('Error getting user data:', error)
      this.users = 0
      this.admins = 0
    }
  },
  methods: {
    async refreshStats() {
      console.log('refreshStats called, userRole:', this.userRole)

      if (this.userRole !== 'admin') {
        this.users = 0
        this.admins = 0
        return
      }

      try {
        const token = auth.getToken()
        const headers = { Authorization: `Bearer ${token}` }

        const userCount = await axios.get('/api/users/count', { headers })
        const adminCount = await axios.get('/api/users/admins/count', { headers })

        //console.log('userCount data:', userCount.data)
        //console.log('adminCount data:', adminCount.data)

        this.users = userCount.data.users
        this.admins = adminCount.data.admins

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
      this.refreshStats()  
    },
    logout() {
      auth.logout()
      this.$router.push('/login')
    }
  }
}
</script>

<style lang="scss" scoped>
@use '../style/admin.scss' as *;
</style>
