<template>
  <div class="user-list">
    <h2>Registered Users</h2>

    <button
      v-if="currentUser.role === 'admin'"
      class="btn-add"
      @click="openForm"
      aria-label="Add new user"
    >
      + Add User
    </button>

    <table aria-label="List of registered users">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.role }}</td>
          <td>
            <!-- View gumb za sve -->
            <button @click="viewUser(user)" aria-label="View user">👁️</button>

            <!-- Edit/Delete samo za admina -->
            <template v-if="currentUser.role === 'admin'">
              <button @click="openForm(user)" aria-label="Edit user">✏️</button>
              <button @click="deleteUser(user.id)" aria-label="Delete user">🗑️</button>
            </template>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modalni popup -->
    <div v-if="showForm" class="modal-overlay" @click.self="closeForm">
      <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <UserForm
          :user="selectedUser"
          @success="handleSubmit"
          @cancel="closeForm"
          :readonly="currentUser.role !== 'admin'" 
        />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import UserForm from './UserForm.vue'


export default {
  components: { UserForm },
  data() {
    return {
      users: [],
      currentUser: {}, 
      showForm: false,
      selectedUser: null,
    }
  },
  async mounted() {
    await this.fetchCurrentUser()
    await this.fetchUsers()
  },
  methods: {
    async fetchUsers() {
      try {
        const token = localStorage.getItem('token')
        const response = await axios.get('/api/users', {
          headers: { Authorization: `Bearer ${token}` },
        })
        this.users = response.data
      } catch (error) {
        console.error('Failed to fetch users:', error)
        alert('Failed to load users')
      }
    },
    async fetchCurrentUser() {
      try {
        const token = localStorage.getItem('token')
        const response = await axios.get('/api/user', {
          headers: { Authorization: `Bearer ${token}` },
        })
        this.currentUser = response.data
      } catch (error) {
        console.error('Failed to fetch current user:', error)
        alert('Failed to load current user')
      }
    },
    openForm(user = null) {
      this.selectedUser = user
      this.showForm = true
    },
    closeForm() {
      this.selectedUser = null
      this.showForm = false
    },
    async handleSubmit(role) {
      this.closeForm()
      await this.fetchUsers()
      this.$emit('refresh-stats')  

      if (role === 'admin') {
        
      }
    },
    async deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
    try {
      const token = localStorage.getItem('token')
      await axios.delete(`/api/users/${id}`, {
        headers: { Authorization: `Bearer ${token}` },
      })
      console.log('User deleted successfully')
      await this.fetchUsers()
      this.$emit('refresh-stats')  
    } catch (error) {
      console.error('Failed to delete user:', error)
      alert('Failed to delete user')
    }
  }
}

,
    viewUser(user) {
      alert(`Name: ${user.name}\nEmail: ${user.email}\nRole: ${user.role}`)
    },
  },
}
</script>

<style lang="scss" scoped>
@use '../style/list.scss' as *;
</style>
