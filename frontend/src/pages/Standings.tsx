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
        <h2 className="py-2.5 pl-1 border-l-[5px] border-secondary text-sm font-bold text-primary my-2.5">BXH NGOẠI HẠNG ANH MÙA GIẢI 2024-2025</h2>
        <table className="w-full text-center">
          <thead>
            <tr className="bg-[#edf2f7] text-xs [&>th]:p-2">
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
          <tbody>
            <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
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
            <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
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
            <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
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
            <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
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
            <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
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
