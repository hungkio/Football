import Tabs from '@/components/Tabs'
import Default from '@/layouts/Default'
import React from 'react'
import Result from './components/Result'
import LiveScore from './components/LiveScore'
import Identify from './components/Identify'
import Forecast from './components/Forecast'
import Bet from './components/Bet'
import BroadcastSchedule from './components/BroadcastSchedule'
import Chart from './components/Chart'
import TopGoal from './components/TopGoal'
import Tournament from './components/Tournament'

const tabs = [
  {
    label: 'Kết quả',
    content: <Result />
  },
  {
    label: 'Trực tuyến',
    content: <LiveScore />
  },
  {
    label: 'Nhận định',
    content: <Identify />
  },
  {
    label: 'Lịch thi đấu',
    content: <Forecast />
  },
  {
    label: 'Kèo bóng đá',
    content: <Bet />
  },
  {
    label: 'Dự đoán',
    content: <Bet />
  },
  {
    label: 'Lịch phát sóng',
    content: <BroadcastSchedule />
  },
  {
    label: 'BXH',
    content: <Chart />
  },
  {
    label: 'Top ghi bàn',
    content: <TopGoal />
  },
  {
    label: 'Giải đấu',
    content: <Tournament />
  }
]

const National = () => {
  return (
    <Default>
      <Tabs tabs={tabs}></Tabs>
    </Default>
  )
}

export default National
