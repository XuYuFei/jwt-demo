import axios from 'axios'
import qs from 'qs'

axios.defaults.timeout = 5000
axios.defaults.baseURL = ''

// http request 拦截器
axios.interceptors.request.use(
  config => {
    config.data = qs.stringify(config.data)
    config.headers = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    let token = (() => {
      return localStorage.getItem('token')
    })()

    let url = config.url
    // 非登录请求，headers添加token
    if (url.indexOf('login') < 0) {
      config.headers.Authorization = token
    }
    // 登录请求，从headers删除token
    if (url.indexOf('login') > -1) {
      localStorage.removeItem('token')
      delete config.headers.Authorization
    }

    return config
  },
  error => {
    return Promise.reject(error)
  }
)

// http response 拦截器
axios.interceptors.response.use(
  response => {
    // 更新token
    if (response.headers.token) {
      localStorage.setItem('token', response.headers.token)
    }

    return response
  },
  error => {
    return Promise.reject(error)
  }
)

export default axios
