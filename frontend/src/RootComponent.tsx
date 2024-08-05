import React from 'react'
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom'
import HomePage from './pages/HomePage'
import LiveScore from './pages/LiveScore'
import NotFoundPage from './pages/NotFoundPage'
import { ROUTES } from './resources/routes-constants'
import NationalOrTournament from './pages/Tournament/NationalOrTournament'
import Result from './pages/Tournament/components/Result'
import Identify from './pages/Tournament/components/Identify'
import Forecast from './pages/Tournament/components/Forecast'
import TournamentStandings from './pages/Tournament/components/Standings'
import TopScores from './pages/Tournament/components/TopScorers'
import Fixtures from './pages/Tournament/components/Fixtures'
import TournamentLiveScore from './pages/Tournament/components/LiveScore'
import Analysis from './pages/Analysis'
import BettingOdds from './pages/BettingOdds'
import News from './pages/News'
import Predictions from './pages/Predictions'
import Standings from './pages/Standings'
import FIFAStandings from './pages/Rankings/FIFAStandings'
import NationalList from './pages/NationalList'
import TopScore from './pages/TopScore'
import Tournament from './pages/Tournament/components/Tournament'

const RootComponent: React.FC = () => {
  return (
    <Router>
      <Routes>
        <Route path="*" element={<NotFoundPage />} />
        <Route path={ROUTES.HOMEPAGE_ROUTE} element={<HomePage />} />
        <Route path={ROUTES.LIVE_ROUTE} element={<LiveScore />} />
        <Route path={ROUTES.TOP_SCORES} element={<TopScore />} />
        <Route path={ROUTES.ANALYTICS} element={<Analysis />} />
        <Route path={ROUTES.PREDICTIONS} element={<Predictions />} />
        <Route path={ROUTES.STANDINGS} element={<Standings />} />
        <Route path={ROUTES.FIFA_STANDINGS} element={<FIFAStandings />} />
        <Route path={ROUTES.BETTING_ODDS} element={<BettingOdds />} />
        <Route path={ROUTES.NATIONAL_TEAMS} element={<NationalList />} />
        <Route path={ROUTES.FIXTURES} element={<HomePage />} />
        <Route path={ROUTES.NEWS} element={<News />} />
        <Route path={ROUTES.NATIONAL_TOURNAMENT} element={<NationalOrTournament />}>
          <Route path={ROUTES.TOURNAMENT_RESULTS} element={<Result />}></Route>
          <Route path={ROUTES.TOURNAMENT_STANDINGS} element={<TournamentStandings />}></Route>
          <Route path={ROUTES.TOURNAMENT_TOP_SCORES} element={<TopScores />}></Route>
          <Route path={ROUTES.TOURNAMENT_FIXTURES} element={<Fixtures />}></Route>
          <Route path={ROUTES.TOURNAMENT_LIVESCORES} element={<TournamentLiveScore />}></Route>
          <Route path={ROUTES.TOURNAMENT_TOURNAMENTS} element={<Tournament />}></Route>
        </Route>
      </Routes>
    </Router>
  )
}

export default RootComponent
