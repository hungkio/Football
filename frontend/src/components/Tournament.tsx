import { Screen } from '@carbon/icons-react'
import React, { memo } from 'react'
import { Link } from 'react-router-dom'

const Tournament = () => {
  return (
    <div>
      <div className="pl-2.5 py-1.5 border-l-4 border-secondary bg-[#edf2f7] flex items-center justify-between">
        <div>
          <Link className="text-primary hover:text-secondary text-xs font-bold" to="/">
            Iraq
          </Link>
          <Link className="text-primary hover:text-secondary text-xs font-bold" to="/">
            {' ⟩ '} Iraq
          </Link>
        </div>
        <div className="ml-auto">
          <Link className="text-primary hover:text-secondary text-xs font-bold mr-2.5" to="/">
            Lịch
          </Link>
          <Link className="text-primary hover:text-secondary text-xs font-bold mr-2.5" to="/">
            Kết quả
          </Link>
          <Link className="text-primary hover:text-secondary text-xs font-bold mr-2.5" to="/">
            BXH
          </Link>
        </div>
        <div className="clear-both"></div>
      </div>
      <div className="flex items-center text-xs py-1.5">
        <div className="w-[65px]">
          <span className="text-primary">45</span>
        </div>
        <div className="w-1/4 text-right">
          <span>Đan Mạch</span>
        </div>
        <div className="w-[65px] text-center">
          <Link className="text-primary hover:text-secondary text-xs font-bold" to={'/'}>
            <span>1</span>
            <span>-</span>
            <span>2</span>
          </Link>
        </div>
        <div className="w-1/4">
          <span>Anh</span>
        </div>
        <div className="w-[65px]">
          <Link className="text-primary hover:text-secondary text-xs font-bold" to={'/'}>
            <span>1</span>
            <span>-</span>
            <span>2</span>
          </Link>
        </div>
        <div className="px-2">
          <Screen />
        </div>
        <div>
          <span> Vòng Bảng / Bảng C </span>
        </div>
      </div>
    </div>
  )
}

export default memo(Tournament)
