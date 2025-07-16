<template>
  <div class="register-container">
    <h1>Sign Up</h1>

    <form class="register-form" @submit.prevent="registerUser">
      <!-- name -->
      <div class="form-group">
        <label for="name">Name</label>
        <input id="name" v-model="form.name" type="text" required />
      </div>

      <!-- email -->
      <div class="form-group">
        <label for="email">E‑mail</label>
        <input id="email" v-model="form.email" type="email" required />
      </div>

      <!-- password -->
      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" v-model="form.password" type="password" required />
      </div>

      <!-- confirm password -->
      <div class="form-group">
        <label for="password_confirmation">Confirm password</label>
        <input
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          required
        />
      </div>

      <!-- role -->
      <div class="form-group">
        <label for="role">Role</label>
        <select id="role" v-model="form.role" required>
          <option disabled value="">Select role</option>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <button class="btn-submit" type="submit">Sign Up</button>
    </form>

    <p v-if="success" class="success">Registration successful ✔</p>
    <p v-if="error"   class="error">{{ error }}</p>

    <p class="switch">
      Already have an account?
      <router-link class="link" to="/login">Sign In</router-link>
    </p>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '', 
        role: '',
      },
      success: false,
      error: null,
    }
  },
  methods: {
    async registerUser() {
      this.success = false
      this.error = null
      try {
        const { data } = await axios.post('/api/register', this.form) 

        localStorage.setItem('token', data.access_token)
        localStorage.setItem('user', JSON.stringify(data.user))

        this.success = true
        setTimeout(() => {
          this.$router.push(data.user.role === 'admin' ? '/admin' : '/dashboard')
        }, 800)
      } catch (err) {
        this.error = err.response?.data?.message || 'Registration failed'
      }
    },
  },
}
</script>

<style lang="scss" scoped>
@use '../style/register.scss' as *;
</style>
