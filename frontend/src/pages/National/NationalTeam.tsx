import Default from '@/layouts/Default'
import React, { useEffect, useState } from 'react'
import { NavLink, Outlet, useLocation, useNavigate, useParams, useSearchParams } from 'react-router-dom'
import { ROUTES } from '@/resources/routes-constants'
import Result from './components/Result'
import Standings from './components/Standings'
import TopScores from './components/TopScorers'
import Fixtures from './components/Fixtures'
import LiveScore from './components/LiveScore'

const NationalTeam = () => {
  const { id } = useParams()
  const [page, setPage] = useState<string | null>(null)
  const location = useLocation()
  const navigate = useNavigate()

  const handleSwitchTab = (param: string) => {
    const searchParams: Record<string, any> = new URLSearchParams(window.location.search)
    if (searchParams.has('results')) searchParams.delete('results')
    if (searchParams.has('livescore')) searchParams.delete('livescore')
    if (searchParams.has('standings')) searchParams.delete('standings')
    if (searchParams.has('top-scores')) searchParams.delete('top-scores')
    if (searchParams.has('fixtures')) searchParams.delete('fixtures')
    setPage(param)
    searchParams.set(param, '')
    navigate(
      {
        search: searchParams.toString()
      },
      { replace: true }
    )
  }

  useEffect(() => {
    const searchParams: Record<string, any> = new URLSearchParams(window.location.search)
    setPage(searchParams.keys().next().value)
  }, [])
  const tabs = [
    {
      label: 'Kết quả',
      url: 'results'
    },
    {
      label: 'Trực tuyến',
      url: 'livescore'
    },
    {
      label: 'Bảng xếp hạng',
      url: 'standings'
    },
    {
      label: 'Top ghi bàn',
      url: 'top-scores'
    },
    {
      label: 'Lịch thi đấu',
      url: 'fixtures'
    }
  ]
  return (
    <Default>
      <h1 className="py-1 px-2.5 bg-[#f9f9f9] mb-2.5 border border-[#eee] font-bold text-secondary">Bóng đá Anh</h1>
      <div className="border-b-2 border-secondary mt-2">
        <ul className="py-2.5 text-nowrap whitespace-nowrap overflow-x-auto flex">
          {tabs.map((tab, index) => {
            return (
              <li key={index}>
                <span
                  onClick={() => handleSwitchTab(tab.url)}
                  className={
                    tab.url === page
                      ? 'px-2.5 py-2 text-xs cursor-pointer bg-secondary text-primary hover:text-red mr-1.5 inline-block'
                      : 'px-2.5 py-2 text-xs cursor-pointer bg-[#f0f0f0] text-primary hover:text-red mr-1.5 inline-block'
                  }
                >
                  {tab.label}
                </span>
              </li>
            )
          })}
        </ul>
      </div>
      {page === 'results' && <Result />}
      {page === 'standings' && <Standings />}
      {page === 'top-scores' && <TopScores />}
      {page === 'fixtures' && <Fixtures />}
      {page === 'livescore' && <LiveScore />}
    </Default>
  )
}

export default NationalTeam
