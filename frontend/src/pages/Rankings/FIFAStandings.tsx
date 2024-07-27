import Default from '@/layouts/Default'
import { ChevronDownOutline, ChevronUp, ChevronUpOutline } from '@carbon/icons-react'
import React from 'react'
import { Helmet } from 'react-helmet'

const FIFAStandings = () => {
  return (
    <Default>
      <Helmet>
        <title>Bảng xếp hạng FIFA 2024 tháng 07 - BXH FIFA mới nhất</title>
      </Helmet>
      <div>
        <h2 className="py-2.5 pl-1 border-l-[5px] border-secondary text-sm font-bold text-primary my-2.5">
          Bảng xếp hạng FIFA 2024 tháng 07 - BXH FIFA mới nhất
        </h2>
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
              <th>Khu vực</th>
            </tr>
          </thead>
          <tbody>
            <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
              <td>1</td>
              <td className="text-left">Argentina</td>
              <td>1</td>
              <td>1901</td>
              <td>1860</td>
              <td>
                41
                <ChevronUpOutline className="ml-1 text-primary inline-block" />
              </td>
              <td>
                0<ChevronUpOutline className="ml-1 text-primary inline-block" />
              </td>
              <td>Nam Mỹ</td>
            </tr>
            <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
              <td>1</td>
              <td className="text-left">Pháp</td>
              <td>2</td>
              <td>1901</td>
              <td>1860</td>
              <td>
                17
                <ChevronUpOutline className="ml-1 text-primary inline-block" />
              </td>
              <td>
                0<ChevronUpOutline className="ml-1 text-primary inline-block" />
              </td>
              <td>Châu Âu</td>
            </tr>
            <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
              <td>1</td>
              <td className="text-left">Tây Ban Nha</td>
              <td>3</td>
              <td>1901</td>
              <td>1860</td>
              <td>
                105
                <ChevronUpOutline className="ml-1 text-primary inline-block" />
              </td>
              <td>
                0<ChevronUpOutline className="ml-1 text-primary inline-block" />
              </td>
              <td>Châu Âu</td>
            </tr>
            <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
              <td>1</td>
              <td className="text-left">Anh</td>
              <td>4</td>
              <td>1901</td>
              <td>1860</td>
              <td>
                24
                <ChevronUpOutline className="ml-1 text-primary inline-block" />
              </td>
              <td>0</td>
              <td>Châu Âu</td>
            </tr>
            <tr className="text-xs [&>td]:p-2 border-b border-[#eee]">
              <td>1</td>
              <td className="text-left">Braxin</td>
              <td>5</td>
              <td>1901</td>
              <td>1860</td>
              <td>
                -6 <ChevronDownOutline className="ml-1 text-red inline-block" />
              </td>
              <td>
                0<ChevronUpOutline className="ml-1 text-primary inline-block" />
              </td>
              <td>Châu Âu</td>
            </tr>
          </tbody>
        </table>
      </div>
    </Default>
  )
}

export default FIFAStandings
