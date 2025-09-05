/** @type {import('next').NextConfig} */
const nextConfig = {
  output: 'standalone',
  basePath: process.env.NODE_ENV === 'production' ? '/exp1-static' : '',
  assetPrefix: process.env.NODE_ENV === 'production' ? '/exp1-static' : '',
  distDir: '.next',
  experimental: {
    serverActions: true,
  },
}

module.exports = nextConfig
