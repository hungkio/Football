import axios from 'axios'
import api from '@/api/api_instance'
import { ILeagueMatches, IMenu, PaginationResponse } from '@/types/app-type'

export const getMenus = (): Promise<IMenu[]> => {
  return api.get('/get-menus/')
}

export const getFixtures = (date: string): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/fixtures/', {
    params: {
      date
    }
  })
}

export const getLiveFixtures = (): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/live-fixtures/')
}
