export default function OrdersPage() {
    const orders = [
        { id: 'ORD-2024-001', date: '2024-02-15', total: 2348, status: 'Delivered', items: 2 },
        { id: 'ORD-2024-042', date: '2024-02-24', total: 159, status: 'Pending', items: 1 },
    ]

    return (
        <div className="card">
            <h2 style={{ marginBottom: '2rem' }}>My Orders</h2>
            <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                {orders.map(order => (
                    <div key={order.id} style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', padding: '1.5rem', border: '1px solid var(--border-color)', borderRadius: '8px' }}>
                        <div>
                            <h3 style={{ fontSize: '1.1rem' }}>{order.id}</h3>
                            <span style={{ color: 'var(--text-muted)', fontSize: '0.9rem' }}>Ordered on {order.date} • {order.items} Items</span>
                        </div>
                        <div style={{ textAlign: 'right', display: 'flex', alignItems: 'center', gap: '2rem' }}>
                            <div>
                                <span style={{ display: 'block', fontWeight: 'bold' }}>${order.total}</span>
                                <span style={{
                                    fontSize: '0.8rem',
                                    color: order.status === 'Delivered' ? 'var(--success)' : 'var(--primary-color)',
                                    background: order.status === 'Delivered' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(0, 210, 255, 0.1)',
                                    padding: '2px 8px',
                                    borderRadius: '12px'
                                }}>{order.status}</span>
                            </div>
                            <button style={{ color: 'var(--primary-color)', fontWeight: 'bold' }}>Details →</button>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    )
}
