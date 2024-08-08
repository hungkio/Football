import Default from '@/layouts/Default'
import React from 'react'
import { NavLink, Outlet, useLocation, useParams } from 'react-router-dom'
import { ROUTES } from '@/resources/routes-constants'

const NationalOrTournament = () => {
  const { id } = useParams()
  const { pathname } = useLocation()
  const tabs = id?.includes('-football')
    ? [
        {
          label: 'Kết quả',
          url: ROUTES.NATIONAL_RESULTS.replace(':id', String(id))
        },
        {
          label: 'Trực tuyến',
          url: ROUTES.NATIONAL_LIVESCORES.replace(':id', String(id))
        },
        {
          label: 'Bảng xếp hạng',
          url: ROUTES.NATIONAL_STANDINGS.replace(':id', String(id))
        },
        {
          label: 'Top ghi bàn',
          url: ROUTES.NATIONAL_TOP_SCORES.replace(':id', String(id))
        },
        {
          label: 'Lịch thi đấu',
          url: ROUTES.NATIONAL_FIXTURES.replace(':id', String(id))
        },
        {
          label: 'Giải đấu',
          url: ROUTES.NATIONAL_TOURNAMENTS.replace(':id', String(id))
        }
      ]
    : [
        {
          label: 'Kết quả',
          url: ROUTES.TOURNAMENT_RESULTS.replace(':id', String(id))
        },
        {
          label: 'Bảng xếp hạng',
          url: ROUTES.TOURNAMENT_STANDINGS.replace(':id', String(id))
        },
        {
          label: 'Top ghi bàn',
          url: ROUTES.TOURNAMENT_TOP_SCORES.replace(':id', String(id))
        },
        {
          label: 'Lịch thi đấu',
          url: ROUTES.TOURNAMENT_FIXTURES.replace(':id', String(id))
        },
        {
          label: 'Livescore',
          url: ROUTES.TOURNAMENT_LIVESCORES.replace(':id', String(id))
        }
      ]
  return (
    <Default>
      <h1 className="py-1 px-2.5 bg-[#f9f9f9] mb-2.5 border border-[#eee] font-bold text-secondary">Giải đấu</h1>
      <div className="border-b-2 border-secondary mt-2">
        <ul className="py-2.5 text-nowrap whitespace-nowrap overflow-x-auto flex">
          {tabs.map((tab, index) => {
            return (
              <li key={index}>
                <NavLink
                  to={tab.url}
                  key={index}
                  end
                  className={({ isActive }) =>
                    isActive
                      ? 'px-2.5 py-2 text-xs cursor-pointer bg-secondary text-primary hover:text-red mr-1.5 inline-block'
                      : 'px-2.5 py-2 text-xs cursor-pointer bg-[#f0f0f0] text-primary hover:text-red mr-1.5 inline-block'
                  }
                >
                  {tab.label}
                </NavLink>
              </li>
            )
          })}
        </ul>
      </div>
      <Outlet />
    </Default>
  )
}

export default NationalOrTournament
