'use client'

import Link from 'next/link'

export default function LoginPage() {
    return (
        <main style={{ minHeight: '80vh', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <div className="card" style={{ width: '400px', display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
                <h2 style={{ textAlign: 'center', color: 'var(--primary-color)' }}>Welcome Back</h2>

                <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                        <label>Email Address</label>
                        <input type="email" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} placeholder="your@email.com" />
                    </div>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                        <div style={{ display: 'flex', justifyContent: 'space-between' }}>
                            <label>Password</label>
                            <Link href="/forgot-password" style={{ fontSize: '0.8rem', color: 'var(--primary-color)' }}>Forgot?</Link>
                        </div>
                        <input type="password" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} placeholder="••••••••" />
                    </div>
                </div>

                <button className="neon-btn" style={{ width: '100%', padding: '1rem' }}>Log In</button>

                <p style={{ textAlign: 'center', fontSize: '0.9rem', color: 'var(--text-muted)' }}>
                    Don't have an account? <Link href="/register" style={{ color: 'var(--primary-color)', fontWeight: 'bold' }}>Register</Link>
                </p>
            </div>
        </main>
    )
}
