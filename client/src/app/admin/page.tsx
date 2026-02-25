export default function AdminDashboardPage() {
    const stats = [
        { label: 'Total Revenue', value: '$124,500', trend: '+12%', color: 'var(--success)' },
        { label: 'Orders Today', value: '42', trend: '+5%', color: 'var(--primary-color)' },
        { label: 'New Customers', value: '18', trend: '+8%', color: 'var(--secondary-color)' },
        { label: 'Active Sessions', value: '156', trend: '-2%', color: 'var(--text-muted)' },
    ]

    return (
        <div>
            <h1 style={{ marginBottom: '2rem' }}>Sales Analytics</h1>

            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: '1.5rem', marginBottom: '3rem' }}>
                {stats.map(stat => (
                    <div key={stat.label} className="card">
                        <span style={{ color: 'var(--text-muted)', fontSize: '0.9rem' }}>{stat.label}</span>
                        <div style={{ display: 'flex', alignItems: 'flex-end', justifyContent: 'space-between', marginTop: '0.5rem' }}>
                            <span style={{ fontSize: '2rem', fontWeight: 'bold' }}>{stat.value}</span>
                            <span style={{ color: stat.color, fontSize: '0.9rem', fontWeight: '600' }}>{stat.trend}</span>
                        </div>
                    </div>
                ))}
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: '2rem' }}>
                <div className="card">
                    <h3 style={{ marginBottom: '1.5rem' }}>Monthly Revenue</h3>
                    <div style={{ height: '300px', width: '100%', background: 'rgba(0, 210, 255, 0.05)', borderRadius: '8px', display: 'flex', alignItems: 'flex-end', justifyContent: 'space-around', padding: '1rem' }}>
                        {[40, 60, 45, 80, 75, 90, 85].map((h, i) => (
                            <div key={i} style={{ width: '30px', height: `${h}%`, background: 'var(--primary-color)', borderRadius: '4px 4px 0 0', opacity: 0.8 }}></div>
                        ))}
                    </div>
                </div>

                <div className="card">
                    <h3 style={{ marginBottom: '1.5rem' }}>Recent Activity</h3>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                        {[1, 2, 3, 4, 5].map(i => (
                            <div key={i} style={{ fontSize: '0.9rem', paddingBottom: '0.75rem', borderBottom: '1px solid var(--border-color)' }}>
                                <span style={{ color: 'var(--primary-color)' }}>John Doe</span> placed an order for $1,299
                                <span style={{ display: 'block', color: 'var(--text-muted)', fontSize: '0.8rem' }}>2 hours ago</span>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </div>
    )
}
