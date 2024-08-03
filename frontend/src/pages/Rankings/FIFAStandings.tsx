import Default from '@/layouts/Default'
import { getCountries } from '@/resources/api-constants'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import { ICountry } from '@/types/app-type'
import { ChevronDownOutline, ChevronUpOutline } from '@carbon/icons-react'
import React, { useEffect, useState } from 'react'
import { Helmet } from 'react-helmet'

const FIFAStandings = () => {
  const [countries, setCountries] = useState<[] | ICountry[]>([])
  const dispatch = useAppDispatch()
  const fetchData = async () => {
    dispatch(loadingAction.show())
    try {
      const result = await getCountries({ perPage: 300 })
      const sortedCountries = result.data.filter((country) => country.rank).sort((a, b) => Number(a.rank) - Number(b.rank))
      setCountries(sortedCountries)
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
        <title>Bảng xếp hạng FIFA 2024 tháng 07 - BXH FIFA mới nhất</title>
      </Helmet>
      <div>
        <div className="py-2.5 pl-1 my-2.5 bg-[#f9f9f9] border border-[#eee]">
          <h1 className="text-sm font-bold text-red">Bảng xếp hạng FIFA 2024 tháng 07 - BXH FIFA mới nhất</h1>
        </div>
        <table className="w-full text-center">
          <thead>
            <tr className="bg-[#edf2f7] text-xs [&>th]:p-2">
              <th>XHKV</th>
              <th className="text-left">ĐTQG</th>
              <th>XH FIFA</th>
              <th>Điểm hiện tại</th>
              <th>Điểm trước</th>
              <th>Điểm+/-</th>
              <th>XH+/-</th>
              <th className="text-right">Khu vực</th>
            </tr>
          </thead>
          <tbody>
            {countries.length > 0 &&
              countries.map((country, index) => {
                return (
                  <tr key={index} className="text-xs [&>td]:p-2 border-b border-[#eee]">
                    <td>{index}</td>
                    <td className="text-left">{country.name_vi ?? country.name}</td>
                    <td>{index}</td>
                    <td>{Math.floor(Number(country.points))}</td>
                    <td>{Math.floor(Number(country.previous_points))}</td>
                    <td>
                      {Math.floor(Number(country.previous_points) - Number(country.points))}
                      {Number(country.previous_points) - Number(country.points) !== 0 ? (
                        Number(country.previous_points) - Number(country.points) > 0 ? (
                          <ChevronDownOutline className="ml-1 text-red inline-block" />
                        ) : (
                          <ChevronUpOutline className="ml-1 text-primary inline-block" />
                        )
                      ) : (
                        ''
                      )}
                    </td>

                    <td>
                      {Math.floor(Number(country.previous_rank) - Number(country.rank))}
                      {Number(country.previous_rank) - Number(country.rank) !== 0 ? (
                        Number(country.previous_rank) - Number(country.rank) > 0 ? (
                          <ChevronDownOutline className="ml-1 text-red inline-block" />
                        ) : (
                          <ChevronUpOutline className="ml-1 text-primary inline-block" />
                        )
                      ) : (
                        ''
                      )}
                    </td>
                    <td className="text-right">{country.region_vi ?? country.region}</td>
                  </tr>
                )
              })}
          </tbody>
        </table>
      </div>
    </Default>
  )
}

export default FIFAStandings
