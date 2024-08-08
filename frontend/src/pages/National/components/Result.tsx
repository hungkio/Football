import Match from '@/components/Match'
import Tournament from '@/components/Tournament'
import { getFixturesByCountry, getFixturesByTeam } from '@/resources/api-constants'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import { ILeagueMatches, IMatch } from '@/types/app-type'
import React, { memo, useEffect, useState } from 'react'
import InfiniteScroll from 'react-infinite-scroll-component'
import { useParams } from 'react-router-dom'

const Result = () => {
  const [matches, setMatches] = useState<IMatch[] | null>(null)
  const [isLoadMore, setIsLoadMore] = useState(true)
  const [page, setPage] = useState(1)
  const dispatch = useAppDispatch()
  const { id } = useParams()
  const fetchData = async (page: number) => {
    try {
      if (id) {
        const teamSlug = id.includes('-football') ? id.replace('-football', '') : id
        const result = await getFixturesByTeam({ teamSlug: teamSlug, type: 0, page })

        if (result.data.length < 15) {
          setIsLoadMore(false)
        }
        if (matches) {
          setMatches([...matches, ...result.data])
        } else {
          setMatches(result.data)
        }
      }
    } catch (error) {
      console.log(error)
    } finally {
      dispatch(loadingAction.hide())
    }
  }
  useEffect(() => {
    dispatch(loadingAction.show())
    fetchData(page)
  }, [id])
  return (
    <div>
      {matches && matches.length > 0 && (
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
          dataLength={matches.length}
        >
          {matches.map((match, index) => {
            return <Match key={index} match={match} />
          })}
        </InfiniteScroll>
      )}
    </div>
  )
}

export default memo(Result)
