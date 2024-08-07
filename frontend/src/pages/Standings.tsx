import Default from '@/layouts/Default'
import React from 'react'
import { Helmet } from 'react-helmet'

const Standings = () => {
  return (
    <Default>
      <Helmet>
        <title>Kết Quả Bóng Đá Tự Động</title>
      </Helmet>
      <div>
        <div className="py-2.5 pl-1 my-2.5 bg-[#f9f9f9] border border-[#eee]">
          <h1 className="text-sm font-bold text-red">BXH NGOẠI HẠNG ANH MÙA GIẢI 2024-2025</h1>
        </div>
        <table className="w-full text-center flex sm:table">
          <thead>
          <tr className="bg-[#edf2f7] text-xs [&>th]:p-2 flex flex-col items-start sm:table-row w-[108px] sm:w-auto">
            <th>XH</th>
            <th className="text-left">Đội</th>
            <th>Trận</th>
            <th>Thắng</th>
            <th>Hoà</th>
            <th>Thua</th>
            <th>Bàn thắng</th>
            <th>Bàn thua</th>
            <th>HS</th>
            <th>Điểm</th>
            <th>Phong độ 5 trận</th>
          </tr>
          </thead>
          <tbody className="flex flex-row sm:table-row-group overflow-auto">
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee] flex flex-col sm:table-row">
            <td>1</td>
            <td className="text-left">Arsenal</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
          </tr>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee] flex flex-col sm:table-row">
            <td>1</td>
            <td className="text-left">Arsenal</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
          </tr>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee] flex flex-col sm:table-row">
            <td>1</td>
            <td className="text-left">Arsenal</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
          </tr>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee] flex flex-col sm:table-row">
            <td>1</td>
            <td className="text-left">Arsenal</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
          </tr>
          <tr className="text-xs [&>td]:p-2 border-b border-[#eee] flex flex-col sm:table-row">
            <td>1</td>
            <td className="text-left">Arsenal</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
          </tr>
          </tbody>
        </table>
      </div>
    </Default>
  )
}

export default Standings
