import Default from '@/layouts/Default'
import { getNationalGroupByRegion } from '@/resources/api-constants'
import { ROUTES } from '@/resources/routes-constants'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import { ICountryRegion } from '@/types/app-type'
import React, { useEffect, useState } from 'react'
import { Helmet } from 'react-helmet'
import { Link } from 'react-router-dom'

const NationalList = () => {
  const [regionList, setRegionList] = useState<[] | ICountryRegion[]>([])
  const dispatch = useAppDispatch()
  const fetchData = async () => {
    dispatch(loadingAction.show())
    try {
      const result = await getNationalGroupByRegion()
      setRegionList(result)
    } catch (error) {
      console.log(error)
    } finally {
      dispatch(loadingAction.hide())
    }
  }

  useEffect(() => {
    fetchData()
  }, [])

  return (
    <Default>
      <Helmet>
        <title>Kết Quả Bóng Đá Tự Động</title>
      </Helmet>
      <div>
        <div className="py-2.5 pl-1 my-2.5 bg-[#f9f9f9] border border-[#eee]">
          <h1 className="text-sm font-bold text-red">ĐTQG Việt Nam: Đội Tuyển Quốc Gia Brazil Argentina Anh Pháp Đức Ý</h1>
        </div>
        {regionList.length > 0 &&
          regionList.map((region, index) => {
            return (
              <div key={index}>
                <h2 className="border-l-4 border-red pl-1 font-bold text-primary my-2.5">{region.name_vi}</h2>
                <ul className="columns-3">
                  {region.items.map((national, index) => {
                    return (
                      <li className="text-xs text-primary cursor-pointer" key={index}>
                        <Link className="flex gap-1 px-2.5" to={ROUTES.NATIONAL_OR_TOURNAMENT.replace(':id', String(national.slug + '-football'))}>
                          <img loading="lazy" className="w-4" src={national.flag} alt={national.name} />
                          {national.name_vi ?? national.name}
                        </Link>
                      </li>
                    )
                  })}
                </ul>
              </div>
            )
          })}
      </div>
    </Default>
  )
}

export default NationalList
