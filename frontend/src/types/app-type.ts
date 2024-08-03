export interface IMenu {
  id: number
  name: string
  status: number
  order_column: number
  external_url: string
  internal_url: string
}

export interface IPeriod {
  first: number
  second: number | null
}

export interface IVenue {
  id: number | null
  city: string
  name: string
}

export interface IStatus {
  long: string
  short: string
  elapsed: number
}

export interface ILeague {
  id: number
  api_id: number
  name: string
  type: 'League' | 'Cup'
  logo: string
  country_code: string
  created_at: string | null
  updated_at: string | null
  slug: string | null
  meta_title: string | null
  meta_description: string | null
  meta_keywords: string | null
  meta_title_vi: string | null
  meta_description_vi: string | null
  meta_keywords_vi: string | null
  vi_name: string | null
  content: string | null
  content_vi: string | null
  bot_body: string | null
  bot_body_vi: string | null
  shown_on_country_standing: number
}

export interface ITeam {
  id: number
  logo: string
  name: string
  winner: boolean | null
}

export interface IGoals {
  away: number
  home: number
}

export interface IScore {
  penalty: {
    away: number | null
    home: number | null
  }
  fulltime: {
    away: number | null
    home: number | null
  }
  halftime: {
    away: number
    home: number
  }
  extratime: {
    away: number | null
    home: number | null
  }
}

export interface IMatch {
  id: number
  api_id: number
  referee: string | null
  timezone: string
  date: string
  timestamp: number
  periods: IPeriod
  venue: IVenue
  status: IStatus
  league: {
    id: number
    flag: string | null
    logo: string
    name: string
    round: string
    season: number
    country: string
  }
  teams: {
    away: ITeam
    home: ITeam
  }
  goals: IGoals
  score: IScore
  created_at: string | null
  updated_at: string | null
  slug: string
  meta_title: string | null
  meta_description: string | null
  meta_keywords: string | null
  meta_title_vi: string | null
  meta_description_vi: string | null
  meta_keywords_vi: string | null
  content: string | null
  vi_content: string | null
  related_posts: string | null
  bot_body: string | null
  bot_body_vi: string | null
}

export interface ILeagueMatches {
  [country: string]: IMatch[]
}

export interface IPost {
  id: number
  user_id: number
  title: string
  description: string
  status: string
  slug: string
  body: string
  view: number
  meta_title: string
  meta_description: string
  meta_keywords: string
  created_at: string
  updated_at: string
  related_posts: string[]
  title_vi: string | null
  description_vi: string | null
  body_vi: string
  meta_title_vi: string | null
  meta_description_vi: string | null
  meta_keywords_vi: string | null
  on_pages: string[]
  tags: string[]
}

export interface ICountry {
  id: number
  api_id: number | null
  name: string
  code: string
  flag: string
  from_team: number
  created_at: string | null
  updated_at: string
  name_vi: string | null
  slug: string | null
  meta_title: string | null
  meta_description: string | null
  meta_keywords: string | null
  meta_title_vi: string | null
  meta_description_vi: string | null
  meta_keywords_vi: string | null
  region: string
  region_id: string
  subregion: string
  subregion_id: string
  rank: string
  previous_rank: string
  points: string
  previous_points: string
  region_vi: string
  subregion_vi: string
}

export interface ICountryRegion {
  name: string
  name_vi: string
  items: ICountry[]
}

export interface PaginateParams {
  page?: number
  per_page?: number
}

export interface PaginationResponse<T extends object> {
  data: T
  current_page: number
  from: number
  last_page: number
  per_page: number
  to: number
  total: number
}
