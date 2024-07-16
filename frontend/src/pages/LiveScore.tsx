import React, { useEffect, useState } from 'react'
import Default from '@/layouts/Default'
import { Helmet } from 'react-helmet'
import Tournament from '@/components/Tournament'
import { getFixtures, getLiveFixtures } from '@/resources/api-constants'
import { ILeagueMatches } from '@/types/app-type'
import { getPrevDate, getPrevDateWithYear } from '@/utility/date'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'

const LiveScore: React.FC = () => {
  const [leagues, setLeagues] = useState<ILeagueMatches | null>(null)
  const dispatch = useAppDispatch()
  useEffect(() => {
    fetchFixtures()
  }, [])
  const fetchFixtures = async () => {
    dispatch(loadingAction.show())
    try {
      const result = await getLiveFixtures()
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
      {leagues &&
        Object.entries(leagues).map((item) => {
          return <Tournament key={item[0]} name={item[0]} matches={item[1]} />
        })}
    </Default>
  )
}

export default LiveScore
