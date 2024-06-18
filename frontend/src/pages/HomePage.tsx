import React from 'react'
import DateDisplay from '../components/DateDisplay'
import Default from '@/layouts/Default'

const HomePage: React.FC = () => {
  return (
    <Default>
      <div className="relative flex w-full justify-center items-center flex-col">
        <DateDisplay />
      </div>
    </Default>
  )
}

export default HomePage
