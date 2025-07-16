/**
 * Glavna ulazna točka aplikacije:
 * 1. uvozi se createApp iz Vue-a za pokretanje aplikacije
 * 2. uvozi se glavna App komponenta i Router za navigaciju
 * 3. kreiranje nove Vue aplikacije te temeju App.vue
 * 4. stavljanje aplikacije na HTML element s ID-jem 'app'
 * */ 

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

createApp(App).use(router).mount('#app')
