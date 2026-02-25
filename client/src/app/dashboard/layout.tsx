'use client'

import { User, Package, Heart, LogOut } from 'lucide-react'
import Link from 'next/link'

export default function DashboardLayout({ children }: { children: React.ReactNode }) {
    const menuItems = [
        { name: 'Profile', icon: User, href: '/dashboard' },
        { name: 'My Orders', icon: Package, href: '/dashboard/orders' },
        { name: 'Wishlist', icon: Heart, href: '/dashboard/wishlist' },
    ]

    return (
        <main className="container" style={{ padding: '3rem 0' }}>
            <div style={{ display: 'flex', gap: '2rem' }}>
                <aside style={{ width: '250px' }}>
                    <div className="card" style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                        {menuItems.map(item => (
                            <Link key={item.name} href={item.href} style={{
                                display: 'flex',
                                alignItems: 'center',
                                gap: '0.75rem',
                                padding: '0.75rem 1rem',
                                borderRadius: '4px',
                                background: 'transparent',
                                transition: 'background 0.3s'
                            }}>
                                <item.icon size={20} />
                                {item.name}
                            </Link>
                        ))}
                        <button style={{
                            display: 'flex',
                            alignItems: 'center',
                            gap: '0.75rem',
                            padding: '0.75rem 1rem',
                            color: 'var(--error)',
                            marginTop: '1rem'
                        }}>
                            <LogOut size={20} /> Logout
                        </button>
                    </div>
                </aside>
                <div style={{ flex: 1 }}>
                    {children}
                </div>
            </div>
        </main>
    )
}
