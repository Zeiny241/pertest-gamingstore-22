'use client'

import { LayoutDashboard, ShoppingBag, ListOrdered, Users, Settings, LogOut } from 'lucide-react'
import Link from 'next/link'

export default function AdminLayout({ children }: { children: React.ReactNode }) {
    const menuItems = [
        { name: 'Dashboard', icon: LayoutDashboard, href: '/admin' },
        { name: 'Products', icon: ShoppingBag, href: '/admin/products' },
        { name: 'Orders', icon: ListOrdered, href: '/admin/orders' },
        { name: 'Users', icon: Users, href: '/admin/users' },
    ]

    return (
        <main style={{ minHeight: '100vh', display: 'flex' }}>
            <aside style={{ width: '280px', background: '#05060a', borderRight: '1px solid var(--border-color)', padding: '2rem' }}>
                <h2 style={{ color: 'var(--primary-color)', marginBottom: '3rem', fontSize: '1.5rem' }}>ADMIN PANEL</h2>

                <nav style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                    {menuItems.map(item => (
                        <Link key={item.name} href={item.href} style={{
                            display: 'flex',
                            alignItems: 'center',
                            gap: '1rem',
                            padding: '1rem',
                            borderRadius: '8px',
                            transition: 'all 0.3s'
                        }}>
                            <item.icon size={20} />
                            {item.name}
                        </Link>
                    ))}
                    <button style={{
                        display: 'flex',
                        alignItems: 'center',
                        gap: '1rem',
                        padding: '1rem',
                        color: 'var(--error)',
                        marginTop: 'auto'
                    }}>
                        <LogOut size={20} /> Logout
                    </button>
                </nav>
            </aside>

            <div style={{ flex: 1, padding: '3rem', background: '#0a0b10' }}>
                {children}
            </div>
        </main>
    )
}
