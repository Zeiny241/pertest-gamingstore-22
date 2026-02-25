export default function AdminOrdersPage() {
    const orders = [
        { id: 'ORD-2024-042', customer: 'John Doe', total: 159, status: 'Paid', date: '2024-02-24' },
        { id: 'ORD-2024-041', customer: 'Jane Smith', total: 1299, status: 'Pending', date: '2024-02-23' },
    ]

    return (
        <div>
            <h1 style={{ marginBottom: '2rem' }}>Order Management</h1>

            <div className="card" style={{ padding: 0 }}>
                <table style={{ width: '100%', borderCollapse: 'collapse', textAlign: 'left' }}>
                    <thead>
                        <tr style={{ borderBottom: '1px solid var(--border-color)', color: 'var(--text-muted)', fontSize: '0.9rem' }}>
                            <th style={{ padding: '1.5rem' }}>Order ID</th>
                            <th style={{ padding: '1.5rem' }}>Customer</th>
                            <th style={{ padding: '1.5rem' }}>Total</th>
                            <th style={{ padding: '1.5rem' }}>Status</th>
                            <th style={{ padding: '1.5rem' }}>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {orders.map(o => (
                            <tr key={o.id} style={{ borderBottom: '1px solid var(--border-color)' }}>
                                <td style={{ padding: '1.5rem' }}>{o.id}</td>
                                <td style={{ padding: '1.5rem' }}>{o.customer}</td>
                                <td style={{ padding: '1.5rem', fontWeight: 'bold' }}>${o.total}</td>
                                <td style={{ padding: '1.5rem' }}>
                                    <span style={{
                                        padding: '4px 12px',
                                        borderRadius: '12px',
                                        fontSize: '0.8rem',
                                        background: o.status === 'Paid' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(0, 210, 255, 0.1)',
                                        color: o.status === 'Paid' ? 'var(--success)' : 'var(--primary-color)'
                                    }}>{o.status}</span>
                                </td>
                                <td style={{ padding: '1.5rem' }}>
                                    <button className="neon-btn" style={{ padding: '0.5rem 1rem' }}>Process</button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    )
}
