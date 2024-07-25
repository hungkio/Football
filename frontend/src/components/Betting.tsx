import { IMatch } from '@/types/app-type'
import { Screen } from '@carbon/icons-react'
import React, { memo, FC } from 'react'
import { Link } from 'react-router-dom'
import Match from './Match'
import BettingMatch from './BettingMatch'

// interface TournamentProps {
//   name: string
//   matches: IMatch[]
// }

const Betting = () => {
  return (
    <div>
      <div className="pl-2.5 py-1.5 bg-[#edf2f7] flex items-center justify-between">
        <div>
          <Link className="text-primary hover:text-red text-xs font-bold" to="/">
            Kèo bóng đá Thế giới
          </Link>
          <Link className="text-primary hover:text-red text-xs font-bold" to="/">
            {' ⟩ '} Olympic Games
          </Link>
          <span className="ml-2 text-xs ml-auto text-white bg-red px-1.5 py-0.5 rounded-3xl">
            <Link to={''}>Cược</Link>
          </span>
        </div>
        <div className="clear-both"></div>
      </div>
      <BettingMatch />
    </div>
  )
}

export default memo(Betting)
