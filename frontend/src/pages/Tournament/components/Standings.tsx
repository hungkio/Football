import { getLeagues, getStandingByLeague } from '@/resources/api-constants'
import { ROUTES } from '@/resources/routes-constants'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import { ILeague, ITeamStanding } from '@/types/app-type'
import { Checkmark, CheckmarkFilled, CloseFilled, SubtractAlt, SubtractFilled } from '@carbon/icons-react'
import React, { useEffect, useState } from 'react'
import InfiniteScroll from 'react-infinite-scroll-component'
import { Link, useParams } from 'react-router-dom'

const Standings = () => {
  const dispatch = useAppDispatch()
  const { id } = useParams()
  const [isLoadMore, setIsLoadMore] = useState(true)
  const [page, setPage] = useState(1)
  const [leagues, setLeagues] = useState<ILeague[] | null>(null)
  const [teams, setTeams] = useState<ITeamStanding[] | null>(null)
  // Page type 1 is National page, 0 is Club page
  const [pageType, setPageType] = useState(1)

  const fetchStandings = async (year?: number) => {
    try {
      if (!id) {
        return
      }
      const currentYear = new Date().getFullYear()
      const result = await getStandingByLeague({ league_slug: id, season: year ?? currentYear })
      if (result.data.length < 15) {
        setIsLoadMore(false)
      }

      if (teams) {
        setTeams([...teams, ...result.data])
      } else {
        setTeams(result.data)
      }
    } catch (error) {
      console.log(error)
    }
  }
  const fetchLeagues = async (page: number) => {
    dispatch(loadingAction.show())
    try {
      if (!id) {
        return
      }
      const result = await getLeagues({ countrySlug: id.includes('-football') ? id.replace('-football', '') : id, countryStandingPage: 1, page })

      if (result.data.length < 15) {
        setIsLoadMore(false)
      }
      setLeagues([...result.data])
    } catch (error) {
      console.log(error)
    } finally {
      dispatch(loadingAction.hide())
    }
  }
  useEffect(() => {
    if (!id?.includes('-football')) {
      setPageType(0)
    }
    fetchStandings()
    fetchLeagues(page)
  }, [id])
  return (
    <div>
      <div className="py-2.5 pl-1 my-2.5 bg-[#f9f9f9] border border-[#eee]">
        <h1 className="text-sm font-bold text-red">BXH NGOẠI HẠNG ANH MÙA GIẢI 2024-2025</h1>
      </div>
      {pageType === 0 && teams && (
        <InfiniteScroll
          style={{
            height: 'unset',
            overflow: 'unset'
          }}
          hasMore={isLoadMore}
          loader={<p>Loading...</p>}
          next={() => {
            setPage((prev) => prev + 1)
            fetchStandings(page + 1)
          }}
          dataLength={teams.length}
        >
          <table className="w-full text-center">
            <thead>
              <tr className="bg-[#edf2f7] text-xs [&>th]:p-2">
                <th>XH</th>
                <th className="text-left">Đội</th>
                <th>Trận</th>
                <th>Thắng</th>
                <th>Hoà</th>
                <th>Thua</th>
                <th>Bàn thắng</th>
                <th>Bàn thua</th>
                <th>HS</th>
                <th>Điểm</th>
                <th>Phong độ 5 trận</th>
              </tr>
            </thead>
            <tbody>
              {teams.map((item, index) => {
                return (
                  <tr key={index} className="text-xs [&>td]:p-2 border-b border-[#eee]">
                    <td>{item.rank}</td>
                    <td className="text-left">{item.team_name}</td>
                    <td>{item.all.played}</td>
                    <td>{item.all.win}</td>
                    <td>{item.all.draw}</td>
                    <td>{item.all.lose}</td>
                    <td>{item.all.goals.for}</td>
                    <td>{item.all.goals.against}</td>
                    <td>{item.goalsDiff}</td>
                    <td>{item.points}</td>
                    <td>
                      {item.five_recent_matches.map((item, index) => {
                        return (
                          <div key={index} className="flex">
                            {item === 'lose' && <CheckmarkFilled className="text-primary" />}
                            {item === 'win' && <SubtractFilled className="text-[#EEE]" />}
                            {item === 'draw' && <CloseFilled className="text-red" />}
                          </div>
                        )
                      })}
                    </td>
                  </tr>
                )
              })}
            </tbody>
          </table>
        </InfiniteScroll>
      )}
      {pageType === 1 && leagues && (
        <InfiniteScroll
          style={{
            height: 'unset',
            overflow: 'unset'
          }}
          hasMore={isLoadMore}
          loader={<p>Loading...</p>}
          next={() => {
            setPage((prev) => prev + 1)
            fetchLeagues(page + 1)
          }}
          dataLength={leagues.length}
        >
          <div className="bg-[#edf2f7] text-left text-xs [&>th]:p-2 flex justify-between px-2 py-2.5">
            <span>Giải đấu</span>
            <span>Cập nhật</span>
          </div>
          {leagues.map((item, index) => {
            return (
              <div key={index} className="text-xs [&>td]:p-2 border-b border-[#eee] px-2 py-2.5 flex justify-between">
                <Link
                  className="text-primary hover:text-red font-bold flex items-center gap-4"
                  to={ROUTES.TOURNAMENT_STANDINGS.replace(':id', item.slug ?? '')}
                >
                  <img className="max-w-5" src={item.logo} alt={item.name} />
                  Vua phá lưới {item.name}
                </Link>
                <div>{new Date(item.updated_at).toLocaleDateString()}</div>
              </div>
            )
          })}
        </InfiniteScroll>
      )}
    </div>
  )
}

export default Standings
