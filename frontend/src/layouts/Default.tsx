import React, { FC, ReactNode } from 'react'
import Header from './components/Header'
import Footer from './components/Footer'
import { Helmet } from 'react-helmet'
import Sidebar from '@/components/Sidebar'
import { useAppSelector } from '@/store/reducers/store'
import { WatsonHealthRotate_180 } from '@carbon/icons-react'
import AdsLeftRight from '@/assets/images/ads-left-right.gif'
import AdsHeader from '@/assets/images/ads-logo.gif'

interface DefaultProps {
  children: ReactNode
}

const Default: FC<DefaultProps> = ({ children }) => {
  const { loading } = useAppSelector((state) => state.loading)
  return (
    <div>
      {loading.show && (
        <div className="z-index-10 fixed w-full h-full bg-black/80 flex items-center justify-center">
          <WatsonHealthRotate_180 className="text-white animate-spin w-20 h-20" />
        </div>
      )}
      <Helmet>
        <title>Kết Quả Bóng Đá Tự Động</title>
        <base href="/" />
      </Helmet>
      <Header />
      <div>
        <div className="fixed top-[190px] right-1/2 mr-[630px]">
          <img className="block" src={AdsLeftRight} alt="" />
          <img className="block" src={AdsLeftRight} alt="" />
          <img className="block" src={AdsLeftRight} alt="" />
        </div>
        <div className="fixed top-[190px] left-1/2 ml-[630px]">
          <img className="block" src={AdsLeftRight} alt="" />
          <img className="block" src={AdsLeftRight} alt="" />
          <img className="block" src={AdsLeftRight} alt="" />
        </div>
        <div className="container mx-auto pb-4">
          <div className="w-[70%] float-left">{children}</div>
          <div className="w-[30%] p-l-5 float-right">
            <Sidebar />
          </div>
          <div className="clear-both"></div>
        </div>
        <div className="fixed bottom-4 left-1/2 -translate-x-1/2">
          <img className="block" src={AdsHeader} alt="" />
          <img className="block" src={AdsHeader} alt="" />
        </div>
      </div>
      <Footer />
    </div>
  )
}

export default Default
