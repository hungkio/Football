import { IMatch } from '@/types/app-type'
import { Screen } from '@carbon/icons-react'
import React, { memo, FC } from 'react'
import { Link } from 'react-router-dom'
import Match from './Match'

interface TournamentProps {
  name: string
  matches: IMatch[]
}

const Tournament: FC<TournamentProps> = ({ name, matches }) => {
  return (
    <div>
      <div className="pl-2.5 py-1.5 border-l-4 border-secondary bg-[#edf2f7] flex items-center justify-between">
        <div>
          <Link className="text-primary hover:text-red text-xs font-bold" to="/">
            {matches[0].league.country}
          </Link>
          <Link className="text-primary hover:text-red text-xs font-bold" to="/">
            {' ⟩ '} {name}
          </Link>
        </div>
        <div className="ml-auto">
          <Link className="text-primary hover:text-red text-xs font-bold mr-2.5" to="/">
            Lịch
          </Link>
          <Link className="text-primary hover:text-red text-xs font-bold mr-2.5" to="/">
            Kết quả
          </Link>
          <Link className="text-primary hover:text-red text-xs font-bold mr-2.5" to="/">
            BXH
          </Link>
        </div>
        <div className="clear-both"></div>
      </div>
      {matches.map((item) => {
        return <Match key={item.id} match={item} />
      })}
    </div>
  )
}

export default memo(Tournament)
