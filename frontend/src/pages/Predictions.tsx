import React, { useEffect, useState } from 'react'
import InfiniteScroll from 'react-infinite-scroll-component'
import Default from '@/layouts/Default'
import { Helmet } from 'react-helmet'
import Tournament from '@/components/Tournament'
import { getFixtures } from '@/resources/api-constants'
import { ILeagueMatches, PaginationResponse } from '@/types/app-type'
import { getPrevDate, getPrevDateWithYear } from '@/utility/date'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import PredictionsList from '@/components/Predictions'

const Predictions: React.FC = () => {
  const [page, setPage] = useState(1)
  const [hasMore, setHasMore] = useState(true)
  const [leagues, setLeagues] = useState<ILeagueMatches | null>(null)
  const numbers = Array.from({ length: 2 }, (_, i) => i)
  const [day, setDay] = useState(0)
  const dispatch = useAppDispatch()
  useEffect(() => {
    fetchFixtures()
  }, [day])
  const fetchFixtures = async () => {
    dispatch(loadingAction.show())
    try {
      const formattedDate = getPrevDateWithYear(day)
      const result = await getFixtures({ date: formattedDate })
      setLeagues(result.data)
    } catch (error) {
      console.log(error)
    } finally {
      dispatch(loadingAction.hide())
    }
  }
  return (
    <Default>
      <Helmet>
        <title>Kết Quả Bóng Đá Tự Động</title>
      </Helmet>
      <div className="flex items-center text-nowrap whitespace-nowrap overflow-x-auto pb-2.5">
        {numbers.map((number) => {
          return (
            <span key={number}>
              {day === number ? (
                <span className="px-3 py-1 bg-secondary rounded text-primary  hover:cursor-pointer text-xs mr-2">{getPrevDate(number)}</span>
              ) : (
                <span
                  className="px-3 py-1 bg-[#dce0e4] rounded text-primary hover:text-primary hover:bg-secondary hover:cursor-pointer text-xs mr-2"
                  onClick={() => setDay(number)}
                >
                  {getPrevDate(number)}
                </span>
              )}
            </span>
          )
        })}
      </div>

      {/* {leagues &&
        Object.entries(leagues).map((item) => {
          return <Tournament key={item[0]} name={item[0]} matches={item[1]} />
        })} */}
      <PredictionsList />
      <PredictionsList />
      <PredictionsList />
      <PredictionsList />
      <PredictionsList />
      <PredictionsList />
    </Default>
  )
}

export default Predictions
