import React, { useEffect, useState } from 'react'
import Default from '@/layouts/Default'
import { Helmet } from 'react-helmet'
import Tournament from '@/components/Tournament'
import { getFixtures } from '@/resources/api-constants'
import { ILeagueMatches } from '@/types/app-type'
import { getPrevDate, getPrevDateWithYear } from '@/utility/date'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'

const HomePage: React.FC = () => {
  const [leagues, setLeagues] = useState<ILeagueMatches | null>(null)
  const numbers = Array.from({ length: 9 }, (_, i) => i)
  const [day, setDay] = useState(0)
  const dispatch = useAppDispatch()
  useEffect(() => {
    fetchFixtures()
  }, [day])
  const fetchFixtures = async () => {
    dispatch(loadingAction.show())
    try {
      const formattedDate = getPrevDateWithYear(day)
      const result = await getFixtures(formattedDate)
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
      {numbers.map((number) => {
        return (
          <span key={number}>
            {day === number ? (
              <span className="px-3 py-1 bg-secondary rounded text-white  hover:cursor-pointer text-xs mr-2">{getPrevDate(number)}</span>
            ) : (
              <span
                className="px-3 py-1 bg-[#dce0e4] rounded text-primary hover:text-secondary hover:cursor-pointer text-xs mr-2"
                onClick={() => setDay(number)}
              >
                {getPrevDate(number)}
              </span>
            )}
          </span>
        )
      })}
      {leagues &&
        Object.entries(leagues).map((item) => {
          return <Tournament key={item[0]} name={item[0]} matches={item[1]} />
        })}
    </Default>
  )
}

export default HomePage
