import axios from 'axios'
import api from '@/api/api_instance'
import { Menu } from '@/types/app-type'

export const getMenus = (): Promise<Menu[]> => {
  return api.get('/get-menus/')
}
