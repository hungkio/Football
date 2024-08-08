import { getLeagues, getStandingByLeague, getTopScoresByLeague, getTopScoresByTeam } from '@/resources/api-constants'
import { ROUTES } from '@/resources/routes-constants'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import { TopScoreLeagueStats } from '@/types/app-type'
import React, { useEffect, useState } from 'react'
import InfiniteScroll from 'react-infinite-scroll-component'
import { Link, useParams } from 'react-router-dom'

const TopScores = () => {
  const dispatch = useAppDispatch()
  const { id } = useParams()
  // Page type 1 is National page, 0 is Club page
  const [leagues, setLeagues] = useState<TopScoreLeagueStats | null>(null)

  const fetchTopScores = async () => {
    try {
      if (!id) {
        return
      }
      const result = await getTopScoresByTeam({ teamSlug: 'arsenal' })
      setLeagues(result)
    } catch (error) {
      console.log(error)
    } finally {
      dispatch(loadingAction.hide())
    }
  }
  useEffect(() => {
    dispatch(loadingAction.show())
    fetchTopScores()
  }, [id])

  return (
    <div>
      <div className="py-2.5 pl-1 my-2.5 bg-[#f9f9f9] border border-[#eee]">
        <h1 className="text-sm font-bold text-red">TOP GHI BÀN BÓNG ĐÁ ANH MỚI NHẤT</h1>
      </div>

      {leagues &&
        Object.entries(leagues).map((item, index) => {
          return (
            <div key={index}>
              <div className="pl-2.5 py-1.5 mb-4 border-l-4 border-secondary bg-[#edf2f7] flex items-center justify-between">
                <div>
                  <span className="text-primary hover:text-red text-xs font-bold">{item[0]}</span>
                </div>
                <div className="clear-both"></div>
              </div>
              <table className="w-full text-center flex sm:table">
                <thead>
                  <tr className="bg-[#edf2f7] text-xs [&>th]:p-2 flex flex-col items-start sm:table-row w-[108px] sm:w-auto">
                    <th>XH</th>
                    <th className="text-left">Cầu thủ</th>
                    <th>Bàn thắng</th>
                    <th>Penalty</th>
                  </tr>
                </thead>

                <tbody className="flex flex-row sm:table-row-group overflow-auto">
                  {item[1][0].map((player, index) => {
                    return (
                      <tr key={index} className="text-xs [&>td]:p-2 border-b border-[#eee] flex flex-col sm:table-row">
                        <td>{index + 1}</td>
                        <td className="text-left">
                          <p>
                            <b>{player.player_name}</b>
                          </p>
                          <p>{player.team_name}</p>
                        </td>
                        <td>{player.goals}</td>
                        <td>{player.penalty}</td>
                      </tr>
                    )
                  })}
                </tbody>
              </table>
            </div>
          )
        })}
    </div>
  )
}

export default TopScores
