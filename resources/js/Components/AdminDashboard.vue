<template>
  <div class="admin-dashboard">
    <div class="header">
      <h1>Admin Dashboard</h1>
      <button @click="logout" class="logout-btn">Logout</button>
    </div>

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
import UserList from './UserList.vue'
import UserForm from './UserForm.vue'
import { auth } from '../store/auth.js'

export default {
  components: { UserList, UserForm },
  data() {
    return {
      showForm: false,
      selectedUser: null,
    }
  },
  methods: {
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
