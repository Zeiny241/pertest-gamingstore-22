'use client'

import { useState } from 'react'
import { CheckCircle2, User, MapPin, CreditCard, ShoppingBag } from 'lucide-react'

export default function CheckoutPage() {
    const [step, setStep] = useState(1)

    const steps = [
        { id: 1, name: 'Info', icon: User },
        { id: 2, name: 'Shipping', icon: MapPin },
        { id: 3, name: 'Payment', icon: CreditCard },
        { id: 4, name: 'Confirm', icon: ShoppingBag },
    ]

    return (
        <main className="container" style={{ padding: '3rem 0', maxWidth: '800px' }}>
            {/* Stepper */}
            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '4rem', position: 'relative' }}>
                <div style={{ position: 'absolute', top: '24px', left: '0', right: '0', height: '2px', background: 'var(--border-color)', zIndex: 0 }}></div>
                {steps.map((s) => (
                    <div key={s.id} style={{ position: 'relative', zIndex: 1, display: 'flex', flexDirection: 'column', alignItems: 'center', gap: '0.5rem' }}>
                        <div style={{
                            width: '50px',
                            height: '50px',
                            borderRadius: '50%',
                            background: step >= s.id ? 'var(--primary-color)' : 'var(--card-bg)',
                            color: step >= s.id ? '#000' : 'var(--text-muted)',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            border: '2px solid',
                            borderColor: step >= s.id ? 'var(--primary-color)' : 'var(--border-color)',
                        }}>
                            <s.icon size={20} />
                        </div>
                        <span style={{ fontSize: '0.8rem', fontWeight: step >= s.id ? 'bold' : 'normal' }}>{s.name}</span>
                    </div>
                ))}
            </div>

            <div className="card">
                {step === 1 && (
                    <div>
                        <h2 style={{ marginBottom: '1.5rem' }}>Contact Information</h2>
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
                            <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                                <label>First Name</label>
                                <input type="text" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} />
                            </div>
                            <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                                <label>Last Name</label>
                                <input type="text" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} />
                            </div>
                        </div>
                        <button onClick={() => setStep(2)} className="neon-btn" style={{ marginTop: '2rem', width: '100%' }}>Continue to Shipping</button>
                    </div>
                )}

                {step === 2 && (
                    <div>
                        <h2 style={{ marginBottom: '1.5rem' }}>Shipping Address</h2>
                        <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                            <textarea placeholder="Line 1" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff', minHeight: '100px' }} />
                            <input type="text" placeholder="City" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} />
                            <input type="text" placeholder="Postal Code" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} />
                        </div>
                        <div style={{ display: 'flex', gap: '1rem', marginTop: '2rem' }}>
                            <button onClick={() => setStep(1)} style={{ flex: 1, padding: '0.75rem', border: '1px solid var(--border-color)', borderRadius: '4px' }}>Back</button>
                            <button onClick={() => setStep(3)} className="neon-btn" style={{ flex: 2 }}>Continue to Payment</button>
                        </div>
                    </div>
                )}

                {step === 3 && (
                    <div>
                        <h2 style={{ marginBottom: '1.5rem' }}>Payment Method</h2>
                        <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                            <label className="card" style={{ display: 'flex', alignItems: 'center', gap: '1rem', cursor: 'pointer' }}>
                                <input type="radio" name="payment" defaultChecked />
                                <span>PromptPay QR (Instant)</span>
                            </label>
                            <label className="card" style={{ display: 'flex', alignItems: 'center', gap: '1rem', cursor: 'pointer' }}>
                                <input type="radio" name="payment" />
                                <span>Credit / Debit Card</span>
                            </label>
                            <label className="card" style={{ display: 'flex', alignItems: 'center', gap: '1rem', cursor: 'pointer' }}>
                                <input type="radio" name="payment" />
                                <span>Bank Transfer (Upload Slip)</span>
                            </label>
                        </div>
                        <div style={{ display: 'flex', gap: '1rem', marginTop: '2rem' }}>
                            <button onClick={() => setStep(2)} style={{ flex: 1, padding: '0.75rem', border: '1px solid var(--border-color)', borderRadius: '4px' }}>Back</button>
                            <button onClick={() => setStep(4)} className="neon-btn" style={{ flex: 2 }}>Review Order</button>
                        </div>
                    </div>
                )}

                {step === 4 && (
                    <div style={{ textAlign: 'center', padding: '2rem 0' }}>
                        <CheckCircle2 size={64} color="var(--success)" style={{ marginBottom: '1.5rem' }} />
                        <h2 style={{ marginBottom: '1rem' }}>Order Confirmed!</h2>
                        <p style={{ color: 'var(--text-muted)', marginBottom: '2rem' }}>Thank you for your purchase. We'll send a confirmation email shortly.</p>
                        <Link href="/products" className="neon-btn">Return to Store</Link>
                    </div>
                )}
            </div>
        </main>
    )
}
