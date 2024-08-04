import BlogPost from '@/components/BlogPost'
import Default from '@/layouts/Default'
import { getAllPosts } from '@/resources/api-constants'
import { useAppDispatch } from '@/store/reducers/store'
import { loadingAction } from '@/store/slice/loading.slice'
import { IPostList } from '@/types/app-type'
import React, { useEffect, useState } from 'react'
import { Helmet } from 'react-helmet'
import InfiniteScroll from 'react-infinite-scroll-component'
import { Link } from 'react-router-dom'

const News = () => {
  const [posts, setPosts] = useState<IPostList[] | null>(null)
  const [isLoadMore, setIsLoadMore] = useState(true)
  const [page, setPage] = useState(1)
  const dispatch = useAppDispatch()
  const fetchData = async (page: number) => {
    try {
      const result = await getAllPosts({ page })

      if (result.data.length < 15) {
        setIsLoadMore(false)
      }
      if (posts) {
        setPosts([...posts, ...result.data])
      } else {
        setPosts(result.data)
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
  }, [])

  console.log(posts)

  return (
    <Default>
      <Helmet>
        <title>Nhận định bóng đá hôm nay</title>
      </Helmet>
      <div className="text-xs p-2.5 bg-[#f6fbff] my-2 *:mb-2">
        <p>
          Nhận định bóng đá hôm nay và ngày mai: Dự đoán kết quả tỷ số bóng đá các trận thi đấu tối và đêm nay. Phân tích tỷ lệ, soi kèo, nhận định, dự đoán đội
          hình dự kiến nhanh và chính xác nhất các giải bóng đá hàng đầu thế giới như: Ngoại Hạng Anh (NHA), La Liga (VĐQG Tây Ban Nha-TBN), Ligue 1 (VĐQG
          Pháp), Serie A (VĐQG Italia-Ý), Bundesliga (VĐQG Đức) và giải V-League của Việt Nam-VN.
        </p>
        <p>
          Nhận định bóng đá Anh, Đức, Pháp, Ý và TBN tối nay NHANH và SỚM nhất, dự đoán tỷ số và kết quả giải đấu World Cup WC Euro Copa America và CAN Cup
          chuẩn xác các trận đấu bóng đá 24h. Siêu máy tính nhận định dự đoán bóng đá ngày mai về kết quả và tỷ số CHÍNH XÁC nhất. Nhận định định bóng đá Ngoại
          Hạng Anh Cúp C1 tối-đêm nay và rạng sáng mai: dự đoán bóng đá chính xác hàng đầu trong nước và thế giới.
        </p>
        <p>
          Nhận định và dự đoán các giải bóng đá hàng đầu Thế Giới-Châu Á-Châu Âu-Nam Mỹ-Bắc Trung Mỹ (Concacaf)-Châu Phi và Châu Đại Dương. Nhận định bóng đá
          chính xác kết quả và tỷ số các giải Cúp C1-C2-C3 Châu Âu-Châu Á-Nam Mỹ và Châu Phi. Chuyên gia nhận định các trận đấu cấp ĐTQG (đội tuyển quốc gia)
          của U23 Việt Nam và ĐTQG Việt Nam (ĐT Việt Nam) ở các giải AFF Cúp-Asian Cup-SEA Games ở giải-cúp vô địch các quốc gia Đông Nam Á.
        </p>
      </div>
      <h1 className="text-primary font-bold mx-2.5 my-5">Tin tức bóng đá hôm nay, tin bóng đá Việt Nam và Thế giới</h1>

      {posts && (
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
          dataLength={posts.length}
        >
          {posts.map((item, index) => {
            return (
              <div key={index}>
                <BlogPost post={item} />
              </div>
            )
          })}
        </InfiniteScroll>
      )}
    </Default>
  )
}

export default News
