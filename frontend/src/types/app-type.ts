export interface IMenu {
  id: number
  name: string
  status: number
  order_column: number
  external_url: string
  internal_url: string
}

export interface IVenue {
  id: number
  city: string
  name: string
}

export interface IStatus {
  long: string
  short: string
  elapsed: number | null
}

export interface IPeriods {
  first: number | null
  second: number | null
}

export interface IFixture {
  id: number
  date: string
  venue: IVenue
  status: IStatus
  periods: IPeriods
  referee: string | null
  timezone: string
  timestamp: number | null
}

export interface ILeague {
  id: number
  flag: string
  logo: string
  name: string
  round: string
  season: number
  country: string
}

export interface ITeam {
  id: number
  logo: string
  name: string
  winner: boolean | null
}

export interface ITeams {
  away: ITeam
  home: ITeam
}

export interface IGoals {
  away: number | null
  home: number | null
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
    away: number | null
    home: number | null
  }
  extratime: {
    away: number | null
    home: number | null
  }
}

export interface IMatch {
  id: number
  fixture: IFixture
  league: ILeague
  teams: ITeams
  goals: IGoals
  score: IScore
  created_at: string
  updated_at: string
}

export interface ILeagueMatches {
  [leagueName: string]: IMatch[]
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
