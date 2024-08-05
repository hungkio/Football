import React, { useEffect, useState } from 'react'
import InfiniteScroll from 'react-infinite-scroll-component'
import { getFixturesByTeam } from '@/resources/api-constants'
import { IMatch } from '@/types/app-type'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import { useParams } from 'react-router-dom'
import Match from '@/components/Match'

const Fixtures: React.FC = () => {
  const [isLoadMore, setIsLoadMore] = useState(true)
  const [page, setPage] = useState(1)
  const [leagues, setLeagues] = useState<IMatch[] | null>(null)
  const dispatch = useAppDispatch()
  const { id } = useParams()
  useEffect(() => {
    fetchData(1)
  }, [])
  const fetchData = async (page: number) => {
    dispatch(loadingAction.show())
    try {
      if (!id) {
        return
      }

      const result = await getFixturesByTeam({ teamSlug: 'manchester-united', status: 1, page })
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
  return (
    <div className="mt-4">
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
            fetchData(page + 1)
          }}
          dataLength={Object.entries(leagues).length}
        >
          {leagues.map((item, index) => {
            return (
              <div key={index}>
                <Match match={item} />
              </div>
            )
          })}
        </InfiniteScroll>
      )}
    </div>
  )
}

export default Fixtures
