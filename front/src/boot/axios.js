import { boot } from 'quasar/wrappers'
import axios from 'axios'
import {Alert} from "src/addons/Alert";
import {useCounterStore} from "stores/example-store";
import moment from 'moment'
// Be careful when using SSR for cross-request state pollution
// due to creating a Singleton instance here;
// If any client changes this (global) instance, it might be a
// good idea to move this instance creation inside of the
// "export default () => {}" function below (which runs individually
// for each client)
const api = axios.create({ baseURL: 'https://api.example.com' })

export default boot(({ app, router }) => {
  // for use inside Vue files (Options API) through this.$axios and this.$api

  app.config.globalProperties.$axios = axios.create({ baseURL: import.meta.env.VITE_API_BACK })
  app.config.globalProperties.$url = import.meta.env.VITE_API_BACK
  app.config.globalProperties.$alert = Alert
  app.config.globalProperties.$store = useCounterStore()
  app.config.globalProperties.$metodos = ['EFECTIVO', 'TRANSFERENCIA']
  app.config.globalProperties.$filters = {
    currency: function (value) {
      return new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR' }).format(value)
    },
    date: function (value) {
      return new Intl.DateTimeFormat('es-ES').format(new Date(value))
    },
    formatdMY: function (value) {
      if (!value) return ''
      const meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic']
      const date = value.split('-')
      return `${date[2]} ${meses[date[1] - 1]} ${date[0]}`
    },
    dateDmYHis (value) {
      const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Nov', 'Dic']
      const mes = meses[moment(String(value)).format('MM') - 1]
      if (!value) return ''
      const date = moment(String(value)).format('DD') + '-' + mes + '-' + moment(String(value)).format('YYYY') + '|' + moment(String(value)).format('HH:mm')
      return date
    },
    formatdMYHID: function (value) {
      if (!value) return ''
      const meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic']
      const date = value.substring(0, 10).split('-')
      const time = value.substring(11, 16)
      return `${date[2]} ${meses[date[1] - 1]} ${date[0]} ${time}`
    },
    capitalizeText: function (value) {
      if (!value) return ''
      const textLower = value.toLowerCase()
      return textLower.charAt(0).toUpperCase() + textLower.slice(1)
    }
  }
  const token = localStorage.getItem('tokenPrestamos')
  if (token) {
    app.config.globalProperties.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    app.config.globalProperties.$axios.get('me').then(response => {
      useCounterStore().isLogged = true
      useCounterStore().user = response.data
    }).catch(error => {
      console.log(error)
      localStorage.removeItem('tokenPrestamos')
      useCounterStore().isLogged = false
      useCounterStore().user = {}
      router.push('/login')
    })
  }
  // ^ ^ ^ this will allow you to use this.$axios (for Vue Options API form)
  //       so you won't necessarily have to import axios in each vue file

  app.config.globalProperties.$api = api
  // ^ ^ ^ this will allow you to use this.$api (for Vue Options API form)
  //       so you can easily perform requests against your app's API
})

export { api }
