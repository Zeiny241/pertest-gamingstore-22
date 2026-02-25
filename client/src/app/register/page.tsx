'use client'

import Link from 'next/link'

export default function RegisterPage() {
    return (
        <main style={{ minHeight: '80vh', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <div className="card" style={{ width: '450px', display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
                <h2 style={{ textAlign: 'center', color: 'var(--primary-color)' }}>Create Account</h2>

                <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                        <label>Full Name</label>
                        <input type="text" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} placeholder="John Doe" />
                    </div>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                        <label>Email Address</label>
                        <input type="email" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} placeholder="your@email.com" />
                    </div>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                        <label>Password</label>
                        <input type="password" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} placeholder="••••••••" />
                    </div>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                        <label>Confirm Password</label>
                        <input type="password" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} placeholder="••••••••" />
                    </div>
                </div>

                <button className="neon-btn" style={{ width: '100%', padding: '1rem' }}>Register</button>

                <p style={{ textAlign: 'center', fontSize: '0.9rem', color: 'var(--text-muted)' }}>
                    Already have an account? <Link href="/login" style={{ color: 'var(--primary-color)', fontWeight: 'bold' }}>Log In</Link>
                </p>
            </div>
        </main>
    )
}
