import Default from '@/layouts/Default'
import React from 'react'
import { NavLink, Outlet, useParams } from 'react-router-dom'
import { ROUTES } from '@/resources/routes-constants'

const NationalTeam = () => {
  const { id } = useParams()
  const tabs = [
    {
      label: 'Kết quả',
      url: ROUTES.NATIONAL_TEAM.replace(':id', String(id))
    },
    {
      label: 'Trực tuyến',
      url: ROUTES.NATIONAL_TEAM_LIVESCORES.replace(':id', String(id))
    },
    {
      label: 'Bảng xếp hạng',
      url: ROUTES.NATIONAL_TEAM_STANDINGS.replace(':id', String(id))
    },
    {
      label: 'Top ghi bàn',
      url: ROUTES.NATIONAL_TEAM_TOP_SCORES.replace(':id', String(id))
    },
    {
      label: 'Lịch thi đấu',
      url: ROUTES.NATIONAL_TEAM_FIXTURES.replace(':id', String(id))
    }
  ]
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

export default NationalTeam