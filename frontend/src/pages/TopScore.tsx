import Default from '@/layouts/Default'
import { getPopularLeagues } from '@/resources/api-constants'
import { ROUTES } from '@/resources/routes-constants'
import { ILeague } from '@/types/app-type'
import React, { useEffect, useState } from 'react'
import { Helmet } from 'react-helmet'
import { Link } from 'react-router-dom'

const TopScore = () => {
  const [leagues, setLeagues] = useState<ILeague[]>([])
  useEffect(() => {
    fetchData()
  }, [])

  const fetchData = async () => {
    try {
      const result = await getPopularLeagues()
      setLeagues(result)
    } catch (error) {
      console.log(error)
    }
  }

  return (
    <Default>
      <Helmet>
        <title>Top ghi bàn Ngoại Hạng Anh, Vua phá lưới Anh TBN Ý Đức Pháp</title>
      </Helmet>
      <div>
        <div className="py-2.5 pl-1 my-2.5 bg-[#f9f9f9] border border-[#eee]">
          <h1 className="text-sm font-bold text-red">Top ghi bàn Ngoại Hạng Anh, Vua phá lưới Anh TBN Ý Đức Pháp</h1>
        </div>
        {leagues.map((item, index) => {
          return (
            <div key={index} className="text-xs [&>td]:p-2 border-b border-[#eee] px-2 py-2.5 flex justify-between">
              <Link className="text-primary hover:text-red font-bold flex items-center gap-4" to={ROUTES.TOURNAMENT_TOP_SCORES.replace(':id', item.slug ?? '')}>
                <img className="max-w-5" src={item.logo} alt={item.name} />
                Vua phá lưới {item.name}
              </Link>
              <div>{new Date(item.updated_at).toLocaleDateString()}</div>
            </div>
          )
        })}
      </div>
    </Default>
  )
}

export default TopScore
