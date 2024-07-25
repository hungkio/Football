import React, { memo, FC } from 'react'
import { Link } from 'react-router-dom'
import { Screen } from '@carbon/icons-react'
import { IMatch } from '@/types/app-type'
import { getReadableDate } from '@/utility/date'

// interface MatchProps {
//   match: IMatch
// }

const Match = () => {
  return (
    <>
      <div className="flex items-center text-xs py-1.5">
        <div className="w-[65px]">
          <span>23:30</span>
        </div>
        <div className="w-1/4 flex justify-end items-center gap-1">
          <span>MFK Ruzomberok</span>
        </div>
        <div className="w-[65px] text-center">
          <span className="text-primary hover:text-red text-xs font-bold">
            <span>2</span>
            <span>-</span>
            <span>5</span>
          </span>
        </div>
        <div className="w-1/4 flex items-center gap-1">
          <span className="font-bold">Trabzonspor</span>
        </div>
        {/* <div className="w-[65px]">
        <Link className="text-primary hover:text-red text-xs font-bold" to={'/'}>
          <span>1</span>
          <span>-</span>
          <span>2</span>
        </Link>
      </div> */}
        <span className="text-xs ml-auto text-white bg-red px-1.5 py-0.5 rounded-3xl">
          <Link to={''}>Cược</Link>
        </span>
      </div>
      <div className="bg-[#edf2f7] border-y border-[#e5e5e5] text-center">
        <span className="font-bold text-xs pr-[200px]">Molde -0.75 &nbsp;&nbsp;&nbsp;&nbsp; Tài 2.75</span>
      </div>
    </>
  )
}

export default memo(Match)
