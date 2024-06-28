import React, { useEffect } from 'react'
import DateDisplay from '../components/DateDisplay'
import Default from '@/layouts/Default'
import { Helmet } from 'react-helmet'
import Tournament from '@/components/Tournament'

const HomePage: React.FC = () => {
  return (
    <Default>
      <Helmet>
        <title>Kết Quả Bóng Đá Tự Động</title>
      </Helmet>
      <Tournament />
      <DateDisplay />
    </Default>
  )
}

export default HomePage
