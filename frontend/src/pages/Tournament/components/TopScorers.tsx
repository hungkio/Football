import { getLeagues, getStandingByLeague } from '@/resources/api-constants'
import { ROUTES } from '@/resources/routes-constants'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import { ILeague } from '@/types/app-type'
import React, { useEffect, useState } from 'react'
import InfiniteScroll from 'react-infinite-scroll-component'
import { Link, useParams } from 'react-router-dom'

const TopScores = () => {
  const dispatch = useAppDispatch()
  const { id } = useParams()
  const [isLoadMore, setIsLoadMore] = useState(true)
  // Page type 1 is National page, 0 is Club page
  const [page, setPage] = useState(1)
  const [pageType, setPageType] = useState(1)
  const [leagues, setLeagues] = useState<ILeague[] | null>(null)
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
  useEffect(() => {
    dispatch(loadingAction.show())
    if (!id?.includes('-football')) {
      setPageType(0)
    }
    fetchLeagues(page)
  }, [])

  return (
    <div>
      <div className="py-2.5 pl-1 my-2.5 bg-[#f9f9f9] border border-[#eee]">
        <h1 className="text-sm font-bold text-red">TOP GHI BÀN BÓNG ĐÁ ANH MỚI NHẤT</h1>
      </div>
      <table className="w-full">
        <thead>
          <tr className="bg-[#edf2f7] text-left text-xs [&>th]:p-2">
            <th>Giải đấu</th>
            <th>Cập nhật</th>
          </tr>
        </thead>
        <tbody>
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
                  <div key={index} className="text-xs [&>td]:p-2 border-b border-[#eee] px-2 py-2.5">
                    <Link
                      className="text-primary hover:text-red font-bold flex items-center gap-4"
                      to={ROUTES.TOURNAMENT_TOP_SCORES.replace(':id', item.slug ?? '')}
                    >
                      <img className="max-w-5" src={item.logo} alt={item.name} />
                      Vua phá lưới {item.name}
                    </Link>
                    <div>{item.updated_at}</div>
                  </div>
                )
              })}
            </InfiniteScroll>
          )}
        </tbody>
      </table>
    </div>
  )
}

export default TopScores
