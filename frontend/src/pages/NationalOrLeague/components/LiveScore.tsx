import React, { useEffect, useState } from 'react'
import InfiniteScroll from 'react-infinite-scroll-component'
import { getFixturesByCountry, getFixturesByLeague, getFixturesByTeam } from '@/resources/api-constants'
import { ILeagueMatches, IMatch } from '@/types/app-type'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import { useParams } from 'react-router-dom'
import Match from '@/components/Match'
import Tournament from '@/components/Tournament'
import { features } from 'process'

const LiveScore: React.FC = () => {
  const [isLoadMore, setIsLoadMore] = useState(true)
  const [page, setPage] = useState(1)
  // Page type 1 is National page, 0 is Club page
  const [pageType, setPageType] = useState(1)
  const [leagues, setLeagues] = useState<ILeagueMatches | null>(null)
  const [fixtures, setFixtures] = useState<IMatch[] | null>(null)
  const dispatch = useAppDispatch()
  const { id } = useParams()
  useEffect(() => {
    dispatch(loadingAction.show())
    if (!id?.includes('-football')) {
      setPageType(0)
      fetchFixturesByLeague(1)
    } else {
      fetchData(1)
    }
  }, [id])

  const fetchFixturesByLeague = async (page: number) => {
    try {
      if (!id) {
        return
      }
      const result = await getFixturesByLeague({ leagueSlug: id, status: 3, page })
      if (result.data.length < 15) {
        setIsLoadMore(false)
      }

      setFixtures([...result.data])
    } catch (error) {
      console.log(error)
    } finally {
      dispatch(loadingAction.hide())
    }
  }

  const fetchData = async (page: number) => {
    try {
      if (id) {
        const teamSlug = id.includes('-football') ? id.replace('-football', '') : id
        const result = await getFixturesByCountry({ countrySlug: teamSlug, status: 3, page })

        if (Object.entries(result.data).length < 15) {
          setIsLoadMore(false)
        }
        if (leagues) {
          setLeagues({ ...leagues, ...result.data })
        } else {
          setLeagues(result.data)
        }
      }
    } catch (error) {
      console.log(error)
    } finally {
      dispatch(loadingAction.hide())
    }
  }

  return (
    <div className="mt-4">
      {pageType === 1 && leagues && (
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
          {Object.entries(leagues).map((item, index) => {
            return <Tournament key={item[0]} name={item[0]} matches={item[1]} />
          })}
        </InfiniteScroll>
      )}
      {pageType === 0 && fixtures && fixtures.length > 0 && (
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
          dataLength={fixtures.length}
        >
          {fixtures.map((item, index) => {
            return <Match key={index} match={item} />
          })}
        </InfiniteScroll>
      )}
    </div>
  )
}

export default LiveScore
