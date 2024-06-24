import React, { memo } from 'react'
import { Link, useLocation } from 'react-router-dom'

const Breadcrumbs = () => {
  const location = useLocation()
  const pathnames = location.pathname.split('/').filter((x) => x)

  return (
    <nav>
      <ul className="breadcrumbs">
        <li>
          <Link className="text-primary hover:text-secondary text-xs" to="/">
            Home
          </Link>
        </li>
        {pathnames.map((value, index) => {
          const to = `/${pathnames.slice(0, index + 1).join('/')}`
          const isLast = index === pathnames.length - 1
          return isLast ? (
            <li key={to}>{value}</li>
          ) : (
            <li key={to}>
              <Link className="text-primary hover:text-secondary text-xs" to={to}>
                » {value}
              </Link>
            </li>
          )
        })}
      </ul>
    </nav>
  )
}

export default memo(Breadcrumbs)
