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
          <div className="w-[100%] md:w-[70%] mb-4 md:mb-0 md:float-left">{children}</div>
          <div className="w-[100%] md:w-[30%] md:float-right">
            <Sidebar />
          </div>
          <div className="clear-both"></div>
        </div>
        <div className="fixed bottom-4 left-1/2 -translate-x-1/2 w-full">
          <img className="block mx-auto" src={AdsHeader} alt="" />
          <img className="block mx-auto" src={AdsHeader} alt="" />
        </div>
      </div>
      <Footer />
    </div>
  )
}

export default Default
