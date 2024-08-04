import { IPostList } from '@/types/app-type'
import React, { FC } from 'react'
import { Link } from 'react-router-dom'

interface BlogPostProps {
  post: IPostList
}

const BlogPost: FC<BlogPostProps> = ({ post }) => {
  return (
    <div className="pb-5 mb-5 border-b border-[#eee] flex gap-4">
      <img src="https://cdn.kqbd.mobi/w150/26.05.2024/nhan-dinh-leeds-united-vs-southampton-21h00-ngay-26-5_1716687132.jpg?v=1716687259" alt="" />
      <div>
        <Link className="text-primary hover:text-red font-bold" to={''}>
          {post.title}
        </Link>
        <p className="text-xs mb-2.5">
          Minh Long - {new Date(post.created_at).toLocaleDateString()} {new Date(post.created_at).toLocaleTimeString()}
        </p>
        <p className="text-xs">{post.description}</p>
      </div>
    </div>
  )
}

export default BlogPost
