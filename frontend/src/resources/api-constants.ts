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

export const getPostsOnPage = (pageId: number, date?: string, perPage?: number): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/posts/', {
    params: {
      page_id: pageId,
      date,
      per_page: perPage
    }
  })
}

export const getPostsByCategory = (categoryId: number, date?: string, perPage?: number): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/api/getPostsByCategory', {
    params: {
      category_id: categoryId,
      date,
      per_page: perPage
    }
  })
}

export const getPostById = (postId: number): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/getPostById/', {
    params: {
      post_id: postId
    }
  })
}

export const getPostsByTag = (tag: string, date?: string): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/getPostsByTag', {
    params: {
      tag,
      date
    }
  })
}

export const getComments = (postId: number): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/comments/', {
    params: {
      post_id: postId
    }
  })
}

export const getCategories = (): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/categories/')
}

export const getCountries = (keyword?: string, perPage?: number): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/countries/', {
    params: {
      keyword,
      per_page: perPage
    }
  })
}

export const getTeams = (keyword?: string, perPage?: number, national?: number): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/teams/', {
    params: {
      keyword,
      per_page: perPage,
      national
    }
  })
}

export const getPlayers = (
  keyword?: string,
  perPage?: number,
  teamId?: number,
  leagueId?: number,
  season?: number
): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/players/', {
    params: {
      keyword,
      per_page: perPage,
      team_id: teamId,
      league_id: leagueId,
      season
    }
  })
}
