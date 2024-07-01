import { WorldCup } from '@/assets'
import { TrophyFilled } from '@carbon/icons-react'
import React, { memo } from 'react'
import { Link } from 'react-router-dom'
import AdsSidebar from '@/assets/images/ads-sidebar.gif'

const listTournament = [
  {
    label: 'Cúp C1 Châu Âu',
    url: '/',
    icon: WorldCup
  },
  {
    label: 'Cúp C2 Châu Âu',
    url: '/',
    icon: WorldCup
  },
  {
    label: 'Cúp C3 Châu Âu',
    url: '/',
    icon: WorldCup
  },
  {
    label: 'V-League',
    url: '/',
    icon: WorldCup
  },
  {
    label: 'Hạng nhất Việt Nam',
    url: '/',
    icon: WorldCup
  },
  {
    label: 'Ngoại Hạng Anh',
    url: '/',
    icon: WorldCup
  },
  {
    label: 'Bundesliga',
    url: '/',
    icon: WorldCup
  },
  {
    label: 'La Liga',
    url: '/',
    icon: WorldCup
  },
  {
    label: 'Serie A',
    url: '/',
    icon: WorldCup
  },
  {
    label: 'Ligue 1',
    url: '/',
    icon: WorldCup
  }
]

const Sidebar = () => {
  return (
    <>
      <div className="mb-4">
        <img className="w-1/2 inline-block" src={AdsSidebar} alt="" />
        <img className="w-1/2 inline-block" src={AdsSidebar} alt="" />
        <img className="w-1/2 inline-block" src={AdsSidebar} alt="" />
        <img className="w-1/2 inline-block" src={AdsSidebar} alt="" />
        <img className="w-1/2 inline-block" src={AdsSidebar} alt="" />
        <img className="w-1/2 inline-block" src={AdsSidebar} alt="" />
        <img className="w-1/2 inline-block" src={AdsSidebar} alt="" />
        <img className="w-1/2 inline-block" src={AdsSidebar} alt="" />
      </div>
      <div className="text-xs bg-[#f0f0f0]">
        <div className="bg-[#dce0e4] py-2 px-1">
          <p className="uppercase font-bold flex items-center">
            <TrophyFilled className="text-red" />
            Giải bóng đá hot nhất
          </p>
        </div>
        <ul className="p-1">
          {listTournament.map((item, index) => {
            return (
              <li className="inline-block w-[48%]" key={index}>
                <Link to={item.url} className="inline-flex gap-1 text-primary hover:text-secondary">
                  <div>
                    <img className="w-4" src={item.icon} alt={item.label} />
                  </div>
                  {item.label}
                </Link>
              </li>
            )
          })}
        </ul>
      </div>
    </>
  )
}

export default memo(Sidebar)
