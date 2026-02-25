'use client'

import { ShoppingCart, Star } from 'lucide-react'

interface ProductProps {
    id: number;
    name: string;
    price: number;
    brand: string;
    rating: number;
    image?: string;
}

export default function ProductCard({ product }: { product: ProductProps }) {
    return (
        <div className="card" style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
            <div style={{ position: 'relative', width: '100%', aspectRatio: '1/1', background: '#0a0a0a', borderRadius: '4px', overflow: 'hidden' }}>
                {product.image ? (
                    <img src={product.image} alt={product.name} style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                ) : (
                    <div style={{ width: '100%', height: '100%', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--text-muted)' }}>
                        No Image
                    </div>
                )}
            </div>

            <div>
                <span style={{ fontSize: '0.8rem', color: 'var(--primary-color)', fontWeight: 'bold' }}>{product.brand}</span>
                <h3 style={{ fontSize: '1.1rem', margin: '0.25rem 0' }}>{product.name}</h3>
                <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', marginBottom: '0.5rem' }}>
                    <Star size={16} fill="gold" stroke="gold" />
                    <span style={{ fontSize: '0.9rem' }}>{product.rating}</span>
                </div>
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                    <span style={{ fontSize: '1.25rem', fontWeight: 'bold', color: '#fff' }}>${product.price}</span>
                    <button className="neon-btn" style={{ padding: '0.5rem' }}>
                        <ShoppingCart size={20} />
                    </button>
                </div>
            </div>
        </div>
    )
}
