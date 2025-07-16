<template>
  <div class="login-container">
    <h1>Login</h1>
    <form @submit.prevent="login"> 
      <div class="form-group">
        <label for="email">Email:</label>
        <input id="email" v-model="email" type="email" required />
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input id="password" v-model="password" type="password" required />
      </div>

      <button class="btn-submit" type="submit">Login</button>
    </form>

    <p class="switch">
      Don’t have an account?
      <router-link class="link" to="/register">Sign Up</router-link>
    </p>

    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'LoginComponent',
  data() {
    return {
      email: '',
      password: '',
      error: null,
    }
  },
  methods: {
    async login() {   
      try {
        const { data } = await axios.post('/api/login', {
          email: this.email,
          password: this.password,
        })
        localStorage.setItem('token', data.access_token)
        localStorage.setItem('user', JSON.stringify(data.user))
        
        if (data.user.role === 'admin') {
          this.$router.push('/admin')
        } else {
          this.$router.push('/dashboard')
        }
      } catch (err) {
        this.error = err.response?.data?.message || 'Login failed'
      }
    },
  },
}
</script>

<style lang="scss" scoped>
@use '../style/login.scss' as *;
</style>
