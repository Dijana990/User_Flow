<template>
  <div class="user-form" aria-label="User form">
    <h3 id="modalTitle">{{ user ? 'Edit User' : 'Add New User' }}</h3>

    <form @submit.prevent="submitForm">
      <label>
        Name:
        <input v-model="form.name" required aria-label="User name" />
      </label>

      <label>
        Email:
        <input v-model="form.email" type="email" required aria-label="User email" />
      </label>

      <label>
        Password:
        <input v-model="form.password" type="password" :required="!user" aria-label="User password" />
      </label>

      <label>
        Role:
        <select v-model="form.role" required aria-label="User role">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </label>

      <div class="actions">
        <button type="submit" aria-label="Save user">💾 Save</button>
        <button type="button" @click="$emit('cancel')" aria-label="Cancel">❌ Cancel</button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    user: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      form: {
        name: '',
        email: '',
        role: 'user',
        password: '',
      },
    }
  },
  watch: {
    user: {
      immediate: true,
      handler(newUser) {
        if (newUser) {
          this.form = {
            name: newUser.name,
            email: newUser.email,
            role: newUser.role,
            password: '',
          }
        } else {
          this.form = {
            name: '',
            email: '',
            role: 'user',
            password: '',
          }
        }
      },
    },
  },
  methods: {
    async submitForm() {
      const token = localStorage.getItem('token')
      const headers = { Authorization: `Bearer ${token}` }

      const payload = { ...this.form }
      if (this.user && !payload.password) {
        delete payload.password
      }

      try {
        if (this.user?.id) {
          await axios.put(`/api/users/${this.user.id}`, payload, { headers })
        } else {
          await axios.post('/api/users', payload, { headers })
        }

        this.$emit('success', payload.role) 
      } catch (error) {
        console.error('Failed to submit user form:', error)
        alert('Error saving user.')
      }
    },
  },
}
</script>

<style lang="scss" scoped>
@use '../style/form.scss' as *;
</style>
