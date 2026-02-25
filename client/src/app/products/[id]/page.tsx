'use client'

import { useState } from 'react'
import { Star, Shield, Truck, RotateCcw, Plus, Minus, ShoppingCart } from 'lucide-react'

export default function ProductDetailsPage({ params }: { params: { id: string } }) {
    const [quantity, setQuantity] = useState(1)

    // Simulation: replace with fetch logic
    const product = {
        id: params.id,
        name: 'NVIDIA RTX 5090 Founders Edition',
        price: 1999,
        brand: 'NVIDIA',
        rating: 4.9,
        reviews: 128,
        stock: 5,
        description: 'The NVIDIA GeForce RTX 5090 is the ultimate GeForce GPU. It brings an enormous leap in performance, efficiency, and AI-powered graphics. Experience ultra-high performance gaming, incredibly detailed virtual worlds with ray tracing, unprecedented productivity, and new ways to create.',
        specs: {
            'Cores': '21760',
            'Memory': '32GB GDDR7',
            'Interface': 'PCIe 5.0 x16',
            'Power': '450W TDP'
        }
    }

    return (
        <main className="container" style={{ padding: '3rem 0' }}>
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '4rem' }}>
                {/* Product Images */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                    <div style={{ aspectRatio: '1/1', background: '#1e293b', borderRadius: '8px', overflow: 'hidden' }}>
                        <div style={{ width: '100%', height: '100%', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--text-muted)' }}>
                            Main Product Image
                        </div>
                    </div>
                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: '1rem' }}>
                        {[1, 2, 3, 4].map(i => (
                            <div key={i} style={{ aspectRatio: '1/1', background: '#1e293b', borderRadius: '4px' }}></div>
                        ))}
                    </div>
                </div>

                {/* Product Info */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
                    <div>
                        <span style={{ color: 'var(--primary-color)', fontWeight: 'bold' }}>{product.brand}</span>
                        <h1 style={{ fontSize: '2.5rem', margin: '0.5rem 0' }}>{product.name}</h1>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
                            <div style={{ display: 'flex', alignItems: 'center', gap: '0.25rem' }}>
                                <Star size={18} fill="gold" stroke="gold" />
                                <span style={{ fontWeight: 'bold' }}>{product.rating}</span>
                            </div>
                            <span style={{ color: 'var(--text-muted)' }}>({product.reviews} Reviews)</span>
                            <span style={{ color: product.stock > 0 ? 'var(--success)' : 'var(--error)' }}>
                                {product.stock > 0 ? `In Stock (${product.stock})` : 'Out of Stock'}
                            </span>
                        </div>
                    </div>

                    <p style={{ fontSize: '2rem', fontWeight: 'bold' }}>${product.price}</p>

                    <p style={{ color: 'var(--text-muted)' }}>{product.description}</p>

                    <div style={{ display: 'flex', alignItems: 'center', gap: '1.5rem' }}>
                        <div style={{ display: 'flex', alignItems: 'center', border: '1px solid var(--border-color)', borderRadius: '4px' }}>
                            <button onClick={() => setQuantity(Math.max(1, quantity - 1))} style={{ padding: '0.75rem' }}><Minus size={18} /></button>
                            <span style={{ width: '40px', textAlign: 'center' }}>{quantity}</span>
                            <button onClick={() => setQuantity(quantity + 1)} style={{ padding: '0.75rem' }}><Plus size={18} /></button>
                        </div>
                        <button className="neon-btn" style={{ flex: 1, display: 'flex', justifyContent: 'center', gap: '1rem', alignItems: 'center' }}>
                            <ShoppingCart size={20} /> Add to Cart
                        </button>
                    </div>

                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem', marginTop: '1rem' }}>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '0.75rem', fontSize: '0.9rem', color: 'var(--text-muted)' }}>
                            <Shield size={20} color="var(--primary-color)" /> 2 Year Warranty
                        </div>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '0.75rem', fontSize: '0.9rem', color: 'var(--text-muted)' }}>
                            <Truck size={20} color="var(--primary-color)" /> Free Shipping
                        </div>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '0.75rem', fontSize: '0.9rem', color: 'var(--text-muted)' }}>
                            <RotateCcw size={20} color="var(--primary-color)" /> 30 Day Returns
                        </div>
                    </div>
                </div>
            </div>

            {/* Specifications Table */}
            <section style={{ marginTop: '5rem' }}>
                <h2 style={{ marginBottom: '2rem' }}>Specifications</h2>
                <div className="card" style={{ padding: 0 }}>
                    {Object.entries(product.specs).map(([key, value], index) => (
                        <div key={key} style={{ display: 'grid', gridTemplateColumns: '1fr 2fr', padding: '1rem 1.5rem', borderBottom: index === 3 ? 'none' : '1px solid var(--border-color)' }}>
                            <span style={{ fontWeight: '600' }}>{key}</span>
                            <span style={{ color: 'var(--text-muted)' }}>{value}</span>
                        </div>
                    ))}
                </div>
            </section>
        </main>
    )
}
