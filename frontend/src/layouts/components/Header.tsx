import React from 'react'
import { Link } from 'react-router-dom'
import Logo from '../../assets/images/logo.png'
import { ROUTES } from '@/resources/routes-constants'
import { Search } from '@carbon/icons-react'
import Breadcrumbs from '@/components/Breadcrumbs'

const navLink = [
  {
    label: 'KQBD',
    url: '/'
  },
  {
    label: 'Trực tuyến',
    url: '/'
  },
  {
    label: 'Nhận định',
    url: '/'
  },
  {
    label: 'Dự đoán',
    url: '/'
  },
  {
    label: 'Lịch thi đấu',
    url: '/'
  },
  {
    label: 'Kèo bóng đá',
    url: '/'
  },
  {
    label: 'Tin tức',
    url: '/'
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
    url: '/'
  },
  {
    label: 'BXH FIFA',
    url: '/'
  },
  {
    label: 'Top ghi bàn',
    url: '/'
  },
  {
    label: 'ĐTQG',
    url: '/'
  },
  {
    label: 'CLB',
    url: '/'
  }
]

const countries = [
  {
    label: 'Anh'
  },
  {
    label: 'TBN'
  },
  {
    label: 'Đức'
  },
  {
    label: 'Pháp'
  },
  {
    label: 'Italia'
  },
  {
    label: 'Brazil'
  },
  {
    label: 'Mỹ'
  },
  {
    label: 'Mexico'
  }
]

const Header = () => {
  return (
    <div>
      <div className="w-full bg-[#efefef]">
        <div className="container mx-auto">
          <ul className="py-2.5">
            {navLink.map((item, index) => {
              return (
                <li key={index} className="float-left px-2.5 py-1.5 text-xs font-bold">
                  <Link className="text-primary" to={item.url}>
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
        <div className="my-2.5">
          <Link to={ROUTES.HOMEPAGE_ROUTE}>
            <img className="block" src={Logo} alt="Logo" />
          </Link>
        </div>
      </div>
      <div className="w-full bg-primary border-b-1.5 border-[#ce2b37] border-b-[3px]">
        <div className="container mx-auto">
          <ul>
            {countries.map((item, index) => {
              return (
                <li key={index}>
                  <Link className="p-3 uppercase bg-primary hover:bg-red text-white block float-left border-r border-[#32ab69] font-bold text-[13px]" to={'/'}>
                    {item.label}
                  </Link>
                </li>
              )
            })}
          </ul>
          <div className="float-right">
            <Link className="p-3.5 bg-red text-white block" to={'/'}>
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
