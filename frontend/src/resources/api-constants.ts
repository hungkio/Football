import axios from 'axios'
import api from '@/api/api_instance'
import {
  ICountry,
  ICountryRegion,
  ILeague,
  ILeagueMatches,
  IMatch,
  IMenu,
  IPost,
  IPostList,
  ITeamStanding,
  ITopScorePlayerResponse,
  PaginationResponse
} from '@/types/app-type'

export const getMenus = (): Promise<IMenu[]> => {
  return api.get('/get-menus/')
}

export const getFixtures = (params: { date: string; perPage?: number; page?: number }): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/fixtures/', {
    params
  })
}

export const getFixturesByTeam = (params: { teamSlug: string; type?: number; perPage?: number; page?: number }): Promise<PaginationResponse<IMatch[]>> => {
  return api.get('/getFixturesByTeam', {
    params: {
      ...params,
      team_slug: params.teamSlug,
      per_page: params.perPage
    }
  })
}

export const getFixturesByCountry = (params: { countrySlug: string; perPage?: number; page?: number }): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/getFixturesByCountry', {
    params: {
      ...params,
      country_slug: params.countrySlug,
      per_page: params.perPage
    }
  })
}

export const getLiveFixtures = (): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/live-fixtures/')
}

export const getAllPosts = (params?: { pageId?: number; date?: string; perPage?: number; page?: number }): Promise<PaginationResponse<IPostList[]>> => {
  return api.get('/allPosts/', {
    params: {
      page_id: params?.pageId,
      date: params?.date,
      per_page: params?.perPage
    }
  })
}

export const getPostsOnPage = (params: { pageId: number; date?: string; perPage?: number; page?: number }): Promise<PaginationResponse<IPostList[]>> => {
  return api.get('/posts/', {
    params: {
      page_id: params.pageId,
      date: params.date,
      per_page: params.perPage
    }
  })
}

export const getPostsByCategory = (params: {
  categoryId: number
  date?: string
  perPage?: number
  page?: number
}): Promise<PaginationResponse<IPostList[]>> => {
  return api.get('/api/getPostsByCategory', {
    params: {
      ...params,
      category_id: params.categoryId,
      per_page: params.perPage
    }
  })
}

export const getPostById = (params: { postId: number }): Promise<IPost> => {
  return api.get('/getPostById/', {
    params: {
      post_id: params.postId
    }
  })
}

export const getPostsByTag = (params: { tag: string; date?: string; perPage?: number; page?: number }): Promise<PaginationResponse<IPostList[]>> => {
  return api.get('/getPostsByTag', {
    params: {
      ...params,
      per_page: params.perPage
    }
  })
}

export const getComments = (params: { postId: number; perPage?: number; page?: number }): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/comments/', {
    params: {
      ...params,
      per_page: params.perPage
    }
  })
}

export const getCategories = (): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/categories/')
}

export const getCountries = (params: { keyword?: string; perPage?: number; page?: number }): Promise<PaginationResponse<ICountry[]>> => {
  return api.get('/countries/', {
    params: {
      ...params,
      per_page: params.perPage
    }
  })
}

export const getLeagues = (params: {
  countrySlug?: string
  countryStandingPage?: number
  perPage?: number
  page?: number
}): Promise<PaginationResponse<ILeague[]>> => {
  return api.get('/leagues', {
    params: {
      ...params,
      country_slug: params.countrySlug,
      countryStandingPage: params.countryStandingPage,
      per_page: params.perPage
    }
  })
}

export const getStandingByLeague = (params: {
  league_slug: string
  season: number
  perPage?: number
  page?: number
}): Promise<PaginationResponse<ITeamStanding[]>> => {
  return api.get('/standingByLeague', {
    params: {
      ...params,
      per_page: params.perPage
    }
  })
}

export const getTopScoresByLeague = (params: { league_slug: string; season: number; perPage?: number; page?: number }): Promise<ITopScorePlayerResponse> => {
  return api.get('/getTopScoresByLeague', {
    params: {
      ...params,
      per_page: params.perPage
    }
  })
}

export const getNationalGroupByRegion = (): Promise<PaginationResponse<ICountryRegion[]>> => {
  return api.get('/nationalGroupByRegion')
}

export const getTeams = (params: { keyword?: string; national?: number; perPage?: number; page?: number }): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/teams/', {
    params: {
      ...params,
      per_page: params.perPage
    }
  })
}

export const getPlayers = (params: {
  keyword?: string
  perPage?: number
  teamId?: number
  leagueId?: number
  season?: number
}): Promise<PaginationResponse<ILeagueMatches>> => {
  return api.get('/players/', {
    params: {
      ...params,
      per_page: params.perPage,
      team_id: params.teamId,
      league_id: params.leagueId
    }
  })
}
