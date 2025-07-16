<template>
  <div class="user-form" aria-label="User form">
    <h3 id="modalTitle">{{ title }}</h3>

    <form @submit.prevent="submitForm">
      <label>
        NAME:
        <input
          v-model="form.name"
          required
          aria-label="User name"
          :readonly="readonly"
        />
      </label>

      <label>
        E-MAIL:
        <input
          v-model="form.email"
          type="email"
          required
          aria-label="User email"
          :readonly="readonly"
        />
      </label>

      <label>
        PASSWORD:
        <input
          v-model="form.password"
          type="password"
          :required="!user"
          aria-label="User password"
          :readonly="readonly"
        />
      </label>

      <label>
        SELECT ROLE:
        <select
          v-model="form.role"
          required
          aria-label="User role"
          :disabled="readonly"
        >
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </label>

      <div class="actions">
        <button v-if="!readonly" type="submit" aria-label="Save user">💾 Save</button>
        <button type="button" @click="$emit('cancel')" aria-label="Cancel">
          ❌ {{ readonly ? 'Close' : 'Cancel' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    user: Object,
    readonly: Boolean,
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
  computed: {
    title() {
      if (this.user) {
        return this.readonly ? 'View User' : 'Edit User'
      }
      return 'Add New User'
    },
  },
  watch: {
    user: {
      immediate: true,
      handler(user) {
        this.form = {
          name: user?.name || '',
          email: user?.email || '',
          role: user?.role || 'user',
          password: '',
        }
      },
    },
  },
  methods: {
    async submitForm() {
      if (this.readonly) return

      const payload = { ...this.form }
      if (this.user && !payload.password) {
        delete payload.password
      }

      const token = localStorage.getItem('token')

      try {
        if (this.user?.id) {
          await axios.put(`/api/users/${this.user.id}`, payload, {
            headers: { Authorization: `Bearer ${token}` },
          })
        } else {
          await axios.post('/api/users', payload, {
            headers: { Authorization: `Bearer ${token}` },
          })
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
