<template>
  <div class="register-container">
    <h1>Register</h1>
    <form @submit.prevent="register" class="register-form">
      <div class="form-group">
        <label for="name">Name</label>
        <input v-model="name" id="name" type="text" placeholder="Name" required />
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="email" id="email" type="email" placeholder="Email" required />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input v-model="password" id="password" type="password" placeholder="Password" required />
      </div>

      <div class="form-group">
        <label for="confirmPassword">Confirm Password</label>
        <input v-model="confirmPassword" id="confirmPassword" type="password" placeholder="Confirm Password" required />
      </div>

      <div class="form-group">
        <label for="role">Role</label>
        <select v-model="role" id="role" required>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <button class="btn-submit" type="submit">Register</button>
    </form>

    <p class="switch">
      Already have an account?
      <router-link class="link" to="/login">Login</router-link>
    </p>

    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'RegisterComponent',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      confirmPassword: '',
      role: 'user',
      error: null,
    }
  },
  methods: {
    async register() {
      this.error = null;

      if (this.password.trim() !== this.confirmPassword.trim()) {
        this.error = 'Passwords do not match.';
        return;
      }

      try {
        const response = await axios.post('/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.confirmPassword, 
          role: this.role, 
        });

        const { access_token, user } = response.data;

        localStorage.setItem('token', access_token);
        localStorage.setItem('user', JSON.stringify(user));

        if (user.role === 'admin') {
          this.$router.push('/admin');
        } else {
          this.$router.push('/dashboard');
        }

      } catch (err) {
        this.error = err.response?.data?.message || 'Registration failed';
      }
    }
    },
  }
</script>

<style lang="scss" scoped>
@use '../style/register.scss' as *;
</style>
