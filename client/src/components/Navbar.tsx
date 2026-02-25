'use client'

import Link from 'next/link'
import { ShoppingCart, User, Search, Heart } from 'lucide-react'

export default function Navbar() {
    return (
        <nav style={{ borderBottom: '1px solid var(--border-color)', height: '70px', display: 'flex', alignItems: 'center' }}>
            <div className="container" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', width: '100%' }}>
                <Link href="/" style={{ fontSize: '1.5rem', fontWeight: 'bold', color: 'var(--primary-color)' }}>
                    GAMING<span style={{ color: '#fff' }}>STORE</span>
                </Link>

                <div style={{ display: 'flex', gap: '2rem', alignItems: 'center' }}>
                    <div style={{ position: 'relative', display: 'flex', alignItems: 'center', background: '#12141d', border: '1px solid var(--border-color)', borderRadius: '4px', padding: '0.5rem 1rem' }}>
                        <Search size={18} style={{ marginRight: '0.5rem', color: 'var(--text-muted)' }} />
                        <input
                            type="text"
                            placeholder="Search hardware..."
                            style={{ background: 'none', border: 'none', color: '#fff', outline: 'none', width: '200px' }}
                        />
                    </div>

                    <div style={{ display: 'flex', gap: '1.5rem' }}>
                        <Link href="/wishlist"><Heart size={20} /></Link>
                        <Link href="/cart"><ShoppingCart size={20} /></Link>
                        <Link href="/login"><User size={20} /></Link>
                    </div>
                </div>
            </div>
        </nav>
    )
}
