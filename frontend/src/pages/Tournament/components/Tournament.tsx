import React from 'react'
import { Link } from 'react-router-dom'

const Tournament = () => {
  return (
    <div>
      <div className="py-2.5 pl-1 my-2.5 bg-[#f9f9f9] border border-[#eee]">
        <h1 className="text-sm font-bold text-red">HỆ THỐNG DANH SÁCH GIẢI ĐẤU BÓNG ĐÁ ANH</h1>
      </div>
      <table className="w-full">
        <thead>
          <tr className="bg-[#edf2f7] text-left text-xs [&>th]:p-2">
            <th>Tên giải đấu</th>
            <th>Hạng</th>
            <th>Thể thức</th>
          </tr>
        </thead>
        <tbody>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
            <td>
              <Link className="text-primary hover:text-red" to={'/'}>
                Ngoại Hạng Anh
              </Link>
            </td>
            <td></td>
            <td>VĐQG</td>
          </tr>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
            <td>
              <Link className="text-primary hover:text-red" to={'/'}>
                Ngoại Hạng Anh
              </Link>
            </td>
            <td></td>
            <td>VĐQG</td>
          </tr>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
            <td>
              <Link className="text-primary hover:text-red" to={'/'}>
                Ngoại Hạng Anh
              </Link>
            </td>
            <td></td>
            <td>VĐQG</td>
          </tr>
        </tbody>
      </table>
    </div>
  )
}

export default Tournament
