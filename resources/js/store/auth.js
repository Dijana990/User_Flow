// /resources/js/store/auth.js

export const auth = {
  getToken() {
    return localStorage.getItem('token')
  },

  setToken(token) {
    localStorage.setItem('token', token)
  },

  clearToken() {
    localStorage.removeItem('token')
  },

  getUserName() {
    return localStorage.getItem('userName')
  },

  setUserName(name) {
    localStorage.setItem('userName', name)
  },

  clearUserName() {
    localStorage.removeItem('userName')
  },

  isLoggedIn() {
    return !!localStorage.getItem('token')
  },

  logout() {
    this.clearToken()
    this.clearUserName()
  }
}
