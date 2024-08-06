import React, { memo, FC } from 'react'
import { Link } from 'react-router-dom'
import { Screen } from '@carbon/icons-react'
import { IMatch } from '@/types/app-type'
import { formatTime } from '@/utility/date'
import { match } from 'assert'

interface MatchProps {
  match: IMatch
}
const Match: FC<MatchProps> = ({ match }) => {
  return (
    <>
      <div className="flex items-center text-xs py-1.5 border-b border-[#eee] last-of-type:border-b-0 flex-wrap">
        <div className="w-[65px] lg:w-auto">
          {(match.status.short === 'NS' || match.status.long === 'Match Finished') && (
            <span className="text-primary">{new Date(match.date).toLocaleString()}</span>
          )}
          {match.status.elapsed && match.status.long !== 'Match Finished' && (
            <span className="text-red">
              {match.status.elapsed}
              {'′'}
            </span>
          )}
          {match.status.long === 'Match Cancelled' && <span>Trận đấu đã bị huỷ</span>}
        </div>
        <div className="w-[calc((100%-105px)/2)] sm:w-[23%] flex justify-end items-center gap-1">
          <img className="w-5" src={match.teams.away.logo} alt="" />
          <span>{match.teams.away.name}</span>
        </div>
        <div className="w-[40px] text-center">
          <Link className="text-primary hover:text-red text-xs font-bold" to={'/'}>
            <span>{match.goals.away}</span>
            <span>-</span>
            <span>{match.goals.home}</span>
          </Link>
        </div>
        <div className="w-[calc((100%-105px)/2)] sm:w-[23%] flex items-center gap-1">
          <img className="w-5" src={match.teams.home.logo} alt="" />
          <span>{match.teams.home.name}</span>
        </div>
        <div className="w-[50%] sm:w-[40px] text-right sm:text-center mt-1 sm:mt-0">
          {match.score.halftime.away !== null && (
            <span className="text-primary hover:text-red text-xs font-bold">
              <span>{match.score.halftime.away}</span>
              <span>-</span>
              <span>{match.score.halftime.home}</span>
            </span>
          )}
        </div>
        <div className="flex flex-1 items-center mt-1 sm:mt-0">
          <div className="px-2">
            <Screen />
          </div>
          <div>
            <span> {match.league.round} </span>
          </div>
        </div>
      </div>
      {match.score.extratime.home !== null && (
        <div>
          <p className="text-center text-red text-xs leading-5 bg-[#edf2f7]">
            120 phút [{match.score.extratime.away} - {match.score.extratime.home}]
            {match.score.extratime.home !== null && (
              <>
                {' '}
                Penalty [{match.score.penalty.away} - {match.score.penalty.home}]
              </>
            )}
          </p>
        </div>
      )}
    </>
  )
}

export default memo(Match)
