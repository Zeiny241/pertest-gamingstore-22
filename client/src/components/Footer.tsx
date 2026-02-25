export default function Footer() {
    return (
        <footer style={{ background: '#05060a', borderTop: '1px solid var(--border-color)', padding: '4rem 0', marginTop: '4rem' }}>
            <div className="container" style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '2rem' }}>
                <div>
                    <h3 style={{ color: 'var(--primary-color)', marginBottom: '1.5rem' }}>GAMINGSTORE</h3>
                    <p style={{ color: 'var(--text-muted)' }}>Premium computer hardware and accessories for serious gamers.</p>
                </div>
                <div>
                    <h4 style={{ marginBottom: '1.5rem' }}>Sitemap</h4>
                    <ul style={{ listStyle: 'none', color: 'var(--text-muted)' }}>
                        <li style={{ marginBottom: '0.5rem' }}><Link href="/products">All Products</Link></li>
                        <li style={{ marginBottom: '0.5rem' }}><Link href="/categories">Categories</Link></li>
                        <li style={{ marginBottom: '0.5rem' }}><Link href="/flash-sale">Flash Sale</Link></li>
                        <li style={{ marginBottom: '0.5rem' }}><Link href="/blog">Tech News</Link></li>
                    </ul>
                </div>
                <div>
                    <h4 style={{ marginBottom: '1.5rem' }}>Customer Service</h4>
                    <ul style={{ listStyle: 'none', color: 'var(--text-muted)' }}>
                        <li style={{ marginBottom: '0.5rem' }}>Shipping Policy</li>
                        <li style={{ marginBottom: '0.5rem' }}>Return & Refund</li>
                        <li style={{ marginBottom: '0.5rem' }}>Contact Us</li>
                    </ul>
                </div>
                <div>
                    <h4 style={{ marginBottom: '1.5rem' }}>Newsletter</h4>
                    <div style={{ display: 'flex', gap: '0.5rem' }}>
                        <input
                            type="email"
                            placeholder="Enter email"
                            style={{ padding: '0.5rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff', outline: 'none' }}
                        />
                        <button className="neon-btn" style={{ padding: '0.5rem 1rem' }}>Sub</button>
                    </div>
                </div>
            </div>
        </footer>
    )
}

import Link from 'next/link'
