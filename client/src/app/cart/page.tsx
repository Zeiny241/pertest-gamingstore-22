'use client'

import { useState } from 'react'
import Link from 'next/link'
import { Trash2, Plus, Minus, ArrowRight } from 'lucide-react'

export default function CartPage() {
    const [items, setItems] = useState([
        { id: 1, name: 'NVIDIA RTX 5090 FE', price: 1999, quantity: 1, image: null },
        { id: 4, name: 'Samsung 990 Pro 4TB', price: 349, quantity: 2, image: null },
    ])

    const subtotal = items.reduce((acc, item) => acc + item.price * item.quantity, 0)
    const shipping = 20
    const total = subtotal + shipping

    const updateQuantity = (id: number, delta: number) => {
        setItems(items.map(item =>
            item.id === id ? { ...item, quantity: Math.max(1, item.quantity + delta) } : item
        ))
    }

    const removeItem = (id: number) => {
        setItems(items.filter(item => item.id !== id))
    }

    return (
        <main className="container" style={{ padding: '3rem 0' }}>
            <h1 style={{ marginBottom: '2rem' }}>Shopping Cart</h1>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 350px', gap: '2rem' }}>
                {/* Cart Items */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                    {items.map(item => (
                        <div key={item.id} className="card" style={{ display: 'flex', gap: '1.5rem', alignItems: 'center' }}>
                            <div style={{ width: '100px', height: '100px', background: '#1e293b', borderRadius: '4px' }}></div>
                            <div style={{ flex: 1 }}>
                                <h3 style={{ fontSize: '1.1rem' }}>{item.name}</h3>
                                <span style={{ color: 'var(--text-muted)', fontSize: '0.9rem' }}>SKU: {item.id}</span>
                            </div>
                            <div style={{ display: 'flex', alignItems: 'center', border: '1px solid var(--border-color)', borderRadius: '4px' }}>
                                <button onClick={() => updateQuantity(item.id, -1)} style={{ padding: '0.5rem' }}><Minus size={16} /></button>
                                <span style={{ width: '30px', textAlign: 'center' }}>{item.quantity}</span>
                                <button onClick={() => updateQuantity(item.id, 1)} style={{ padding: '0.5rem' }}><Plus size={16} /></button>
                            </div>
                            <div style={{ width: '100px', textAlign: 'right', fontWeight: 'bold' }}>
                                ${item.price * item.quantity}
                            </div>
                            <button onClick={() => removeItem(item.id)} style={{ color: 'var(--error)', padding: '0.5rem' }}>
                                <Trash2 size={20} />
                            </button>
                        </div>
                    ))}

                    {items.length === 0 && (
                        <div className="card" style={{ textAlign: 'center', padding: '4rem' }}>
                            <h3>Your cart is empty</h3>
                            <Link href="/products" className="neon-btn" style={{ display: 'inline-block', marginTop: '1rem' }}>Shop Now</Link>
                        </div>
                    )}
                </div>

                {/* Order Summary */}
                <div className="card" style={{ height: 'fit-content', display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
                    <h2 style={{ fontSize: '1.5rem' }}>Order Summary</h2>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '0.75rem' }}>
                        <div style={{ display: 'flex', justifyContent: 'space-between' }}>
                            <span style={{ color: 'var(--text-muted)' }}>Subtotal</span>
                            <span>${subtotal}</span>
                        </div>
                        <div style={{ display: 'flex', justifyContent: 'space-between' }}>
                            <span style={{ color: 'var(--text-muted)' }}>Estimated Shipping</span>
                            <span>${shipping}</span>
                        </div>
                        <div style={{ display: 'flex', justifyContent: 'space-between', borderTop: '1px solid var(--border-color)', paddingTop: '0.75rem', marginTop: '1rem', fontWeight: 'bold', fontSize: '1.25rem' }}>
                            <span>Total</span>
                            <span style={{ color: 'var(--primary-color)' }}>${total}</span>
                        </div>
                    </div>
                    <Link href="/checkout" className="neon-btn" style={{ textAlign: 'center', display: 'flex', justifyContent: 'center', gap: '0.5rem', alignItems: 'center' }}>
                        Checkout <ArrowRight size={18} />
                    </Link>
                </div>
            </div>
        </main>
    )
}
