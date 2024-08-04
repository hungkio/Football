import React from 'react'
import { Link } from 'react-router-dom'

const TopScores = () => {
  return (
    <div>
      <div className="py-2.5 pl-1 my-2.5 bg-[#f9f9f9] border border-[#eee]">
        <h1 className="text-sm font-bold text-red">TOP GHI BÀN BÓNG ĐÁ ANH MỚI NHẤT</h1>
      </div>
      <table className="w-full">
        <thead>
          <tr className="bg-[#edf2f7] text-left text-xs [&>th]:p-2">
            <th>Giải đấu</th>
            <th>Cập nhật</th>
          </tr>
        </thead>
        <tbody>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
            <td>
              <Link className="text-primary hover:text-red font-bold" to={'/'}>
                Vua phá lưới Ngoại Hạng Anh 2023-2024
              </Link>
            </td>
            <td>15/05/2024 13:30:02</td>
          </tr>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
            <td>
              <Link className="text-primary hover:text-red font-bold" to={'/'}>
                Vua phá lưới Cúp FA 2022-2023
              </Link>
            </td>
            <td>15/05/2024 13:30:02</td>
          </tr>
        </tbody>
      </table>
    </div>
  )
}

export default TopScores
