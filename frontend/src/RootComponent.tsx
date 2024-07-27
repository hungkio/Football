import React from 'react'
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom'
import HomePage from './pages/HomePage'
import LiveScore from './pages/LiveScore'
import NotFoundPage from './pages/NotFoundPage'
import { ROUTES } from './resources/routes-constants'
import National from './pages/National/National'
import Result from './pages/National/components/Result'
import Identify from './pages/National/components/Identify'
import Forecast from './pages/National/components/Forecast'
import TournamentStandings from './pages/National/components/Standings'
import TopScores from './pages/National/components/TopScorers'
import Fixtures from './pages/National/components/Fixtures'
import TournamentLiveScore from './pages/National/components/LiveScore'
import Analysis from './pages/Analysis'
import BettingOdds from './pages/BettingOdds'
import News from './pages/News'
import Predictions from './pages/Predictions'
import Standings from './pages/Standings'
import FIFAStandings from './pages/Rankings/FIFAStandings'

const RootComponent: React.FC = () => {
  return (
    <Router>
      <Routes>
        <Route path="*" element={<NotFoundPage />} />
        <Route path={ROUTES.HOMEPAGE_ROUTE} element={<HomePage />} />
        <Route path={ROUTES.LIVE_ROUTE} element={<LiveScore />} />
        <Route path={ROUTES.ANALYTICS} element={<Analysis />} />
        <Route path={ROUTES.PREDICTIONS} element={<Predictions />} />
        <Route path={ROUTES.STANDINGS} element={<Standings />} />
        <Route path={ROUTES.FIFA_STANDINGS} element={<FIFAStandings />} />
        <Route path={ROUTES.BETTING_ODDS} element={<BettingOdds />} />
        <Route path={ROUTES.FIXTURES} element={<HomePage />} />
        <Route path={ROUTES.NEWS} element={<News />} />
        <Route path={ROUTES.TOURNAMENT} element={<National />}>
          <Route path={ROUTES.TOURNAMENT_RESULTS} element={<Result />}></Route>
          <Route path={ROUTES.TOURNAMENT_STANDINGS} element={<TournamentStandings />}></Route>
          <Route path={ROUTES.TOURNAMENT_TOP_SCORES} element={<TopScores />}></Route>
          <Route path={ROUTES.TOURNAMENT_FIXTURES} element={<Fixtures />}></Route>
          <Route path={ROUTES.TOURNAMENT_LIVESCORES} element={<TournamentLiveScore />}></Route>
        </Route>
      </Routes>
    </Router>
  )
}

export default RootComponent
