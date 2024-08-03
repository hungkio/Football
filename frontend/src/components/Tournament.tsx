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
    <div className="mt-4">
      <div className="pl-2.5 py-1.5 border-l-4 border-secondary bg-[#edf2f7] flex items-center justify-between">
        <div>
          <Link className="text-primary hover:text-red text-xs font-bold" to="/">
            {name}
          </Link>
        </div>
        <div className="clear-both"></div>
      </div>
      {matches.map((item, index) => {
        return <Match key={index} match={item} />
      })}
    </div>
  )
}

export default memo(Tournament)
