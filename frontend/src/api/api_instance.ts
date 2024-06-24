import axios from 'axios'

const api = axios.create({
  baseURL: 'https://api.demo.kqbd.ai/api',
  headers: {
    'Content-Type': 'application/json'
  }
})
api.interceptors.request.use(
  (request) => {
    return request
  },
  (error) => {
    return Promise.reject(error)
  }
)

api.interceptors.response.use(
  (response) => {
    return response.data
  },
  (error) => {
    return Promise.reject(error)
  }
)

export default api
