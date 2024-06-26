import React, { memo, FC } from 'react'
import { Link } from 'react-router-dom'
import { Screen } from '@carbon/icons-react'
import { IMatch } from '@/types/app-type'

interface MatchProps {
  match: IMatch
}

const Match: FC<MatchProps> = ({ match }) => {
  return (
    <div className="flex items-center text-xs py-1.5">
      <div className="w-[65px]">
        {match.fixture.status.short === 'NS' || (match.fixture.status.short === 'FT' && <span className="text-primary">{match.fixture.date}</span>)}
        {match.fixture.status.short !== 'NS' && match.fixture.status.short !== 'FT' && (
          <span className="text-red">
            {match.fixture.status.elapsed}
            {'′'}
          </span>
        )}
      </div>
      <div className="w-1/4 flex justify-end items-center gap-1">
        <img className="w-5" src={match.teams.away.logo} alt="" />
        <span>{match.teams.away.name}</span>
      </div>
      <div className="w-[65px] text-center">
        <Link className="text-primary hover:text-secondary text-xs font-bold" to={'/'}>
          <span>{match.goals.away}</span>
          <span>-</span>
          <span>{match.goals.home}</span>
        </Link>
      </div>
      <div className="w-1/4 flex items-center gap-1">
        <img className="w-5" src={match.teams.home.logo} alt="" />
        <span>{match.teams.home.name}</span>
      </div>
      {/* <div className="w-[65px]">
        <Link className="text-primary hover:text-secondary text-xs font-bold" to={'/'}>
          <span>1</span>
          <span>-</span>
          <span>2</span>
        </Link>
      </div> */}
      <div className="px-2">
        <Screen />
      </div>
      <div>
        <span> {match.league.round} </span>
      </div>
    </div>
  )
}

export default memo(Match)
