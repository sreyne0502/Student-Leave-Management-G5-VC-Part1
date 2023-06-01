import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index'
import vuetify from './plugins/vuetify'
import Navigation from "./navigation/NavigationBar.vue"
import Button from "./components/ButtonComponent.vue"
import allowCard from "./components/status/CardAdminAllow.vue"
import { loadFonts } from './plugins/webfontloader'
loadFonts()


createApp(App)
  .use(router)
  .use(vuetify)
  .component("Navigation-Bar",Navigation)
  .component("Button-View",Button)
  .component("allow-View",allowCard)
  .mount('#app')
