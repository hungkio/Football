import axios from 'axios'
import api from '@/api/api_instance'
import { ILeagueMatches, IMenu } from '@/types/app-type'

export const getMenus = (): Promise<IMenu[]> => {
  return api.get('/get-menus/')
}

export const getLiveFixtures = (): Promise<ILeagueMatches> => {
  return api.get('/live-fixtures/')
}
