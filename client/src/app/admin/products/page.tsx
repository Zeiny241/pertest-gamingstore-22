import { Plus, Edit, Trash2 } from 'lucide-react'

export default function AdminProductsPage() {
    const products = [
        { id: 1, name: 'NVIDIA RTX 5090 FE', category: 'GPU', stock: 5, price: 1999 },
        { id: 2, name: 'AMD Ryzen 9 9950X', category: 'CPU', stock: 12, price: 649 },
        { id: 3, name: 'Samsung 990 Pro 4TB', category: 'SSD', stock: 45, price: 349 },
    ]

    return (
        <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '2rem' }}>
                <h1>Manage Products</h1>
                <button className="neon-btn" style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                    <Plus size={20} /> Add Product
                </button>
            </div>

            <div className="card" style={{ padding: 0 }}>
                <table style={{ width: '100%', borderCollapse: 'collapse', textAlign: 'left' }}>
                    <thead>
                        <tr style={{ borderBottom: '1px solid var(--border-color)', color: 'var(--text-muted)', fontSize: '0.9rem' }}>
                            <th style={{ padding: '1.5rem' }}>Product</th>
                            <th style={{ padding: '1.5rem' }}>Category</th>
                            <th style={{ padding: '1.5rem' }}>Stock</th>
                            <th style={{ padding: '1.5rem' }}>Price</th>
                            <th style={{ padding: '1.5rem' }}>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {products.map(p => (
                            <tr key={p.id} style={{ borderBottom: '1px solid var(--border-color)' }}>
                                <td style={{ padding: '1.5rem', fontWeight: 'bold' }}>{p.name}</td>
                                <td style={{ padding: '1.5rem' }}>{p.category}</td>
                                <td style={{ padding: '1.5rem' }}>
                                    <span style={{ color: p.stock < 10 ? 'var(--error)' : 'inherit' }}>{p.stock}</span>
                                </td>
                                <td style={{ padding: '1.5rem' }}>${p.price}</td>
                                <td style={{ padding: '1.5rem' }}>
                                    <div style={{ display: 'flex', gap: '1rem' }}>
                                        <button style={{ color: 'var(--primary-color)' }}><Edit size={18} /></button>
                                        <button style={{ color: 'var(--error)' }}><Trash2 size={18} /></button>
                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    )
}
