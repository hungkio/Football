import React, { FC, ReactNode } from 'react'
import Header from './components/Header'
import Footer from './components/Footer'

interface DefaultProps {
  children: ReactNode
}

const Default: FC<DefaultProps> = ({ children }) => {
  return (
    <div>
      <Header />
      <div>{children}</div>
      <Footer />
    </div>
  )
}

export default Default
