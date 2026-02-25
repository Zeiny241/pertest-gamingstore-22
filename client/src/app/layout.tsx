import './globals.css'
import type { Metadata } from 'next'
import Navbar from '../components/Navbar'
import Footer from '../components/Footer'
import LiveChat from '../components/LiveChat'

export const metadata: Metadata = {
    title: 'Gaming Store - Premium Hardware',
    description: 'The best computer hardware and accessories for gamers.',
}

export default function RootLayout({
    children,
}: {
    children: React.ReactNode
}) {
    return (
        <html lang="en">
            <body>
                <Navbar />
                {children}
                <LiveChat />
                <Footer />
            </body>
        </html>
    )
}
