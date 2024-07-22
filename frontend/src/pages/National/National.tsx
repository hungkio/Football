import Tabs from '@/components/Tabs'
import Default from '@/layouts/Default'
import React from 'react'
import Result from './components/Result'
import LiveScore from './components/LiveScore'
import Identify from './components/Identify'
import Forecast from './components/Forecast'
import Bet from './components/BettingOdds'
import BroadcastSchedule from './components/BroadcastSchedule'
import Standings from './components/Standings'
import TopScores from './components/TopScorers'
import Tournament from './components/Tournament'
import { NavLink, Outlet } from 'react-router-dom'
import Schedule from './components/Fixtures'
import { ROUTES } from '@/resources/routes-constants'

const tabs = [
  {
    label: 'Kết quả',
    url: ROUTES.TOURNAMENT_RESULTS.replace(':id', 'anh')
  },
  {
    label: 'Bảng xếp hạng',
    url: ROUTES.TOURNAMENT_STANDINGS.replace(':id', 'anh')
  },
  {
    label: 'Top ghi bàn',
    url: ROUTES.TOURNAMENT_TOP_SCORES.replace(':id', 'anh')
  },
  {
    label: 'Lịch thi đấu',
    url: ROUTES.TOURNAMENT_FIXTURES.replace(':id', 'anh')
  },
  {
    label: 'Livescore',
    url: ROUTES.TOURNAMENT_LIVESCORES.replace(':id', 'anh')
  }
]

const National = () => {
  return (
    <Default>
      <h1 className="py-1 px-2.5 bg-[#f9f9f9] mb-2.5 border border-[#eee] font-bold text-secondary">Bóng đá Anh</h1>
      <div className="border-b-2 border-secondary mt-2">
        {tabs.map((tab, index) => {
          return (
            <>
              <NavLink to={tab.url} key={index} className="px-2.5 py-2 text-xs cursor-pointer bg-[#f0f0f0] text-primary hover:text-red mr-1.5 inline-block">
                {tab.label}
              </NavLink>
            </>
          )
        })}
      </div>
      <Outlet />
    </Default>
  )
}

export default National
