import React, { FC, ReactNode } from 'react'
import Header from './components/Header'
import Footer from './components/Footer'
import { Helmet } from 'react-helmet'
import Sidebar from '@/components/Sidebar'

interface DefaultProps {
  children: ReactNode
}

const Default: FC<DefaultProps> = ({ children }) => {
  return (
    <div>
      <Helmet>
        <title>Kết Quả Bóng Đá Tự Động</title>
      </Helmet>
      <Header />
      <div className="container mx-auto">
        <div className="w-[70%] float-left">{children}</div>
        <div className="w-[30%] p-l-5 float-right">
          <Sidebar />
        </div>
        <div className="clear-both"></div>
      </div>
      <Footer />
    </div>
  )
}

export default Default
