import { getLeagues, getStandingByLeague } from '@/resources/api-constants'
import { ROUTES } from '@/resources/routes-constants'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import { ILeague } from '@/types/app-type'
import React, { useEffect, useState } from 'react'
import InfiniteScroll from 'react-infinite-scroll-component'
import { Link, useParams } from 'react-router-dom'

const Standings = () => {
  const dispatch = useAppDispatch()
  const { id } = useParams()
  const [isLoadMore, setIsLoadMore] = useState(true)
  const [page, setPage] = useState(1)
  const [leagues, setLeagues] = useState<ILeague[] | null>(null)

  const fetchStandings = async (year?: number) => {
    try {
      if (!id) {
        return
      }
      const currentYear = new Date().getFullYear()
      const result = await getStandingByLeague({ league_slug: id, season: year ?? currentYear })
      console.log(result)
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
    fetchStandings()
    fetchLeagues(page)
  }, [])
  return (
    <div>
      <div className="py-2.5 pl-1 my-2.5 bg-[#f9f9f9] border border-[#eee]">
        <h1 className="text-sm font-bold text-red">BXH NGOẠI HẠNG ANH MÙA GIẢI 2024-2025</h1>
      </div>
      {leagues && (
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
          {leagues.map((item, index) => {
            return (
              <tr key={index} className="text-xs [&>td]:p-2 border-b border-[#eee]">
                <td>
                  <Link
                    className="text-primary hover:text-red font-bold flex items-center gap-4"
                    to={ROUTES.TOURNAMENT_STANDINGS.replace(':id', item.slug ?? '')}
                  >
                    <img className="max-w-5" src={item.logo} alt={item.name} />
                    BXH {item.name}
                  </Link>
                </td>
                <td>{item.updated_at}</td>
              </tr>
            )
          })}
        </InfiniteScroll>
      )}
      {/* <table className="w-full text-center">
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
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
            <td>1</td>
            <td className="text-left">Arsenal</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
          </tr>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
            <td>1</td>
            <td className="text-left">Arsenal</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
          </tr>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
            <td>1</td>
            <td className="text-left">Arsenal</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
          </tr>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
            <td>1</td>
            <td className="text-left">Arsenal</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
          </tr>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
            <td>1</td>
            <td className="text-left">Arsenal</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
          </tr>
        </tbody>
      </table> */}
    </div>
  )
}

export default Standings
