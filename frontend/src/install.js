import Vue from 'vue'
import Install from './Install.vue'
import store from './store'
Vue.config.productionTip = false

new Vue({
  store,
  render: h => h(Install)
}).$mount('#install')
