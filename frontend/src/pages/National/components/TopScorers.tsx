import { getLeagues, getStandingByLeague, getTopScoresByLeague } from '@/resources/api-constants'
import { ROUTES } from '@/resources/routes-constants'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import { ILeague, ITopScorePlayer } from '@/types/app-type'
import React, { useEffect, useState } from 'react'
import InfiniteScroll from 'react-infinite-scroll-component'
import { Link, useParams } from 'react-router-dom'

const TopScores = () => {
  const dispatch = useAppDispatch()
  const { id } = useParams()
  const [isLoadMore, setIsLoadMore] = useState(true)
  const [page, setPage] = useState(1)
  // Page type 1 is National page, 0 is Club page
  const [pageType, setPageType] = useState(1)
  const [leagues, setLeagues] = useState<ILeague[] | null>(null)
  const [players, setPlayers] = useState<ITopScorePlayer[] | null>(null)

  const fetchTopScores = async (year?: number) => {
    try {
      if (!id) {
        return
      }
      const currentYear = new Date().getFullYear()
      const result = await getTopScoresByLeague({ league_slug: id, season: year ?? currentYear })
      setPlayers(result.data)
    } catch (error) {
      console.log(error)
    }
  }
  const fetchLeagues = async (page: number) => {
    try {
      if (!id) {
        return
      }
      const result = await getLeagues({ countrySlug: id.includes('-football') ? id.replace('-football', '') : id, countryStandingPage: 1, page })

      if (result.data.length < 15) {
        setIsLoadMore(false)
      }
      if (leagues) {
        setLeagues([...leagues, ...result.data])
      } else {
        setLeagues(result.data)
      }
    } catch (error) {
      console.log(error)
    } finally {
      dispatch(loadingAction.hide())
    }
  }
  console.log(players)
  useEffect(() => {
    dispatch(loadingAction.show())
    if (!id?.includes('-football')) {
      setPageType(0)
    }
    fetchTopScores()
    fetchLeagues(page)
  }, [id])

  return (
    <div>
      <div className="py-2.5 pl-1 my-2.5 bg-[#f9f9f9] border border-[#eee]">
        <h1 className="text-sm font-bold text-red">TOP GHI BÀN BÓNG ĐÁ ANH MỚI NHẤT</h1>
      </div>
      {pageType === 0 && (
        <table className="w-full text-center flex sm:table">
          <thead>
            <tr className="bg-[#edf2f7] text-xs [&>th]:p-2 flex flex-col items-start sm:table-row w-[108px] sm:w-auto">
              <th>XH</th>
              <th className="text-left">Đội bóng</th>
              <th>Bàn thắng</th>
              <th>Penalty</th>
            </tr>
          </thead>
          {players && players?.length > 0 && (
            <tbody className="flex flex-row sm:table-row-group overflow-auto">
              {players.map((item, index) => {
                return (
                  <tr key={index} className="text-xs [&>td]:p-2 border-b border-[#eee] flex flex-col sm:table-row">
                    <td>{index + 1}</td>
                    <td className="text-left">
                      <p>{item.player_name}</p>
                      <p>{item.team}</p>
                    </td>
                    <td>{item.goals}</td>
                    <td>{item.penalty}</td>
                  </tr>
                )
              })}
            </tbody>
          )}
        </table>
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
                  to={ROUTES.TOURNAMENT_TOP_SCORES.replace(':id', item.slug ?? '')}
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

export default TopScores
