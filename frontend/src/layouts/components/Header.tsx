import React, { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'
import Logo from '../../assets/images/Logo-No-slogan.png'
import { ROUTES } from '@/resources/routes-constants'
import { Search } from '@carbon/icons-react'
import Breadcrumbs from '@/components/Breadcrumbs'
import { getMenus } from '@/resources/api-constants'
import { IMenu } from '@/types/app-type'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import AdsHeader from '@/assets/images/ads-logo.gif'

const navLink = [
  {
    label: 'KQBD',
    url: '/'
  },
  {
    label: 'Trực tuyến',
    url: ROUTES.LIVE_ROUTE
  },
  {
    label: 'Kết quả',
    url: ROUTES.RESULTS
  },
  {
    label: 'Nhận định',
    url: ROUTES.ANALYTICS
  },
  {
    label: 'Dự đoán',
    url: ROUTES.PREDICTIONS
  },
  {
    label: 'Lịch thi đấu',
    url: ROUTES.FIXTURES
  },
  {
    label: 'Kèo bóng đá',
    url: ROUTES.BETTING_ODDS
  },
  {
    label: 'Tin tức',
    url: ROUTES.NEWS
  },
  {
    label: 'Lịch phát sóng',
    url: '/'
  },
  {
    label: 'Đối đầu',
    url: '/'
  },
  {
    label: 'BXH',
    url: ROUTES.STANDINGS
  },
  {
    label: 'BXH FIFA',
    url: ROUTES.FIFA_STANDINGS
  },
  {
    label: 'Top ghi bàn',
    url: ROUTES.TOP_SCORES
  },
  {
    label: 'ĐTQG',
    url: ROUTES.NATIONAL_TEAMS
  },
  {
    label: 'CLB',
    url: '/'
  }
]

// const countries = [
//   {
//     label: 'Anh'
//   },
//   {
//     label: 'TBN'
//   },
//   {
//     label: 'Đức'
//   },
//   {
//     label: 'Pháp'
//   },
//   {
//     label: 'Italia'
//   },
//   {
//     label: 'Brazil'
//   },
//   {
//     label: 'Mỹ'
//   },
//   {
//     label: 'Mexico'
//   }
// ]

const Header = () => {
  const [navLinks, setNavLinks] = useState<IMenu[]>([])
  const [isMenuVisible, setIsMenuVisible] = useState(false)
  const [countries, setCountries] = useState<IMenu[]>([])
  const dispatch = useAppDispatch()
  const fetchMenu = async () => {
    dispatch(loadingAction.show())
    try {
      const result = await getMenus()
      setCountries(result.sort((a, b) => a.order_column - b.order_column))
    } catch (error) {
      console.log(error)
    } finally {
      dispatch(loadingAction.hide())
    }
  }

  const toggleMenu = () => {
    setIsMenuVisible(!isMenuVisible)
  }

  useEffect(() => {
    fetchMenu()
  }, [])

  return (
    <div>
      <div className="w-full bg-[#efefef]">
        <div className="container mx-auto">
          <ul className="py-2.5 text-nowrap whitespace-nowrap overflow-x-auto flex">
            {navLink.map((item, index) => {
              return (
                <li key={index} className="px-2.5 py-1.5 text-xs font-bold">
                  <Link className="text-primary hover:text-red" to={item.url}>
                    {item.label}
                  </Link>
                </li>
              )
            })}
            <div className="clear-both"></div>
          </ul>
        </div>
      </div>
      <div className="mx-auto container">
        <div className="my-2.5 flex justify-between items-center">
          <Link className="inline" to={ROUTES.HOMEPAGE_ROUTE}>
            <img className="block w-[206px]" src={Logo} alt="Logo" />
          </Link>
          <img src={AdsHeader} alt="" />
        </div>
      </div>
      <div className="w-full bg-primary border-b-1.5 border-secondary border-b-[3px]">
        <div className="container mx-auto flex">
          <nav className="flex flex-wrap items-center justify-between w-full">
            <svg
              onClick={toggleMenu}
              xmlns="http://www.w3.org/2000/svg"
              id="menu-button"
              className="h-[44px] w-6 cursor-pointer md:hidden block text-white"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>

            <div className={`w-full flex md:items-center md:w-auto ${isMenuVisible ? '' : 'hidden'} md:flex`} id="menu">
              <ul>
                {countries.map((item, index) => {
                  return (
                    <li key={index} className="border-r border-secondary last:border-none md:float-left">
                      <Link
                        className="p-3 uppercase bg-primary hover:bg-secondary text-white hover:text-primary float-left font-bold text-[13px] inline-block"
                        to={item.external_url ?? item.internal_url}
                      >
                        {item.name}
                      </Link>
                    </li>
                  )
                })}
              </ul>
            </div>
          </nav>
          <div className="float-right">
            <Link className="p-3.5 bg-secondary text-white block" to={'/'}>
              <Search />
            </Link>
          </div>
          <div className="clear-both"></div>
        </div>
      </div>
      <div className="container mx-auto">
        <div className="flex items-center text-nowrap whitespace-nowrap overflow-x-auto">
          <span className="text-red font-bold text-xs">HOT:</span>
          <ul className="py-1.5">
            {navLink.map((item, index) => {
              return (
                <li key={index} className="inline-block px-1.5 text-xs border-r border-[#d6d6d6]">
                  <Link className="text-primary hover:text-red" to={item.url}>
                    {item.label}
                  </Link>
                </li>
              )
            })}
            {navLink.map((item, index) => {
              return (
                <li key={index} className="inline-block px-1.5 text-xs border-r border-[#d6d6d6]">
                  <Link className="text-primary hover:text-red" to={item.url}>
                    {item.label}
                  </Link>
                </li>
              )
            })}
            <div className="clear-both"></div>
          </ul>
        </div>
      </div>
      <div className="container mx-auto">
        <Breadcrumbs />
      </div>
    </div>
  )
}

export default Header
