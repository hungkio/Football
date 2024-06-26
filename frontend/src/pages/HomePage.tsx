import React, { useEffect, useState } from 'react'
import DateDisplay from '../components/DateDisplay'
import Default from '@/layouts/Default'
import { Helmet } from 'react-helmet'
import Tournament from '@/components/Tournament'
import { getLiveFixtures } from '@/resources/api-constants'
import { ILeagueMatches } from '@/types/app-type'

const HomePage: React.FC = () => {
  const [leagues, setLeagues] = useState<ILeagueMatches | null>(null)
  useEffect(() => {
    fetchLive()
  }, [])
  const fetchLive = async () => {
    try {
      const result = await getLiveFixtures()
      setLeagues(result)
    } catch (error) {
      console.log(error)
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
      <DateDisplay />
    </Default>
  )
}

export default HomePage
