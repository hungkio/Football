import React from 'react'
import { Link } from 'react-router-dom'

const BlogPost = () => {
  return (
    <div className="pb-5 mb-5 border-b border-[#eee] flex gap-4">
      <img src="https://cdn.kqbd.mobi/w150/26.05.2024/nhan-dinh-leeds-united-vs-southampton-21h00-ngay-26-5_1716687132.jpg?v=1716687259" alt="" />
      <div>
        <Link className="text-primary hover:text-red font-bold" to={''}>
          Nhận định Leeds United vs Southampton, 21h00 ngày 26/5
        </Link>
        <p className="text-xs mb-2.5">Minh Long - 26/05/2024 08:32</p>
        <p className="text-xs">
          Nhận định Leeds United vs Southampton, dự đoán bóng đá hạng nhất Anh hôm nay 21h00 ngày 26/5 chính xác. Nhận định bóng đá Anh: dự đoán kết quả tỷ số
          trận chung kết play-off thăng hạng tối và đêm nay nhanh nhất.
        </p>
      </div>
    </div>
  )
}

export default BlogPost
