'use client'

import { useState, useEffect } from 'react'
import ProductCard from '../components/ProductCard'
import { Filter, SlidersHorizontal } from 'lucide-react'

export default function ProductsPage() {
    const [products, setProducts] = useState([])
    const [loading, setLoading] = useState(true)

    // Simulation: replace with fetch logic when connected
    useEffect(() => {
        setTimeout(() => {
            setProducts([
                { id: 1, name: 'NVIDIA RTX 5090 FE', price: 1999, brand: 'NVIDIA', rating: 4.9 },
                { id: 2, name: 'AMD Ryzen 9 9950X', price: 649, brand: 'AMD', rating: 4.8 },
                { id: 3, name: 'Corsair Dominator Titanium 64GB', price: 299, brand: 'Corsair', rating: 4.7 },
                { id: 4, name: 'Samsung 990 Pro 4TB', price: 349, brand: 'Samsung', rating: 4.9 },
                { id: 5, name: 'ASUS ROG Swift PG32UCDM', price: 1299, brand: 'ASUS', rating: 4.8 },
                { id: 6, name: 'Logitech G Pro X Superlight 2', price: 159, brand: 'Logitech', rating: 4.9 },
            ])
            setLoading(false)
        }, 1000)
    }, [])

    return (
        <main className="container" style={{ padding: '2rem 0' }}>
            <div style={{ display: 'flex', gap: '2rem' }}>
                {/* Sidebar Filters */}
                <aside style={{ width: '250px', display: 'flex', flexDirection: 'column', gap: '2rem' }}>
                    <div className="card">
                        <h3 style={{ marginBottom: '1rem', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                            <Filter size={18} /> Filters
                        </h3>

                        <div style={{ marginBottom: '1.5rem' }}>
                            <h4 style={{ fontSize: '0.9rem', marginBottom: '0.5rem' }}>Category</h4>
                            <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                                <label><input type="checkbox" /> Graphics Cards</label>
                                <label><input type="checkbox" /> Processors</label>
                                <label><input type="checkbox" /> Memory</label>
                                <label><input type="checkbox" /> Storage</label>
                            </div>
                        </div>

                        <div style={{ marginBottom: '1.5rem' }}>
                            <h4 style={{ fontSize: '0.9rem', marginBottom: '0.5rem' }}>Price Range</h4>
                            <input type="range" style={{ width: '100%' }} />
                            <div style={{ display: 'flex', justifyContent: 'space-between', fontSize: '0.8rem' }}>
                                <span>$0</span>
                                <span>$3000+</span>
                            </div>
                        </div>
                    </div>
                </aside>

                {/* Product Grid */}
                <div style={{ flex: 1 }}>
                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1.5rem' }}>
                        <h2>All Products ({products.length})</h2>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                            <SlidersHorizontal size={18} />
                            <select style={{ background: 'var(--card-bg)', color: '#fff', border: '1px solid var(--border-color)', padding: '0.5rem', borderRadius: '4px' }}>
                                <option>Newest Arrivals</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Most Popular</option>
                            </select>
                        </div>
                    </div>

                    {loading ? (
                        <div style={{ textAlign: 'center', padding: '4rem' }}>Loading products...</div>
                    ) : (
                        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(250px, 1fr))', gap: '2rem' }}>
                            {products.map(product => (
                                <ProductCard key={product.id} product={product} />
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </main>
    )
}
