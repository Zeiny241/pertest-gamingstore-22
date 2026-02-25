'use client'

import { useState } from 'react'
import { MessageSquare, X, Send } from 'lucide-react'

export default function LiveChat() {
    const [isOpen, setIsOpen] = useState(false)

    return (
        <div style={{ position: 'fixed', bottom: '2rem', right: '2rem', zIndex: 1000 }}>
            {isOpen ? (
                <div className="card" style={{ width: '320px', height: '450px', display: 'flex', flexDirection: 'column', padding: 0, boxShadow: '0 10px 40px rgba(0,0,0,0.5)' }}>
                    <div style={{ background: 'var(--primary-color)', color: '#000', padding: '1rem', display: 'flex', justifyContent: 'space-between', alignItems: 'center', borderRadius: '8px 8px 0 0' }}>
                        <h3 style={{ fontSize: '1rem' }}>Gaming Support</h3>
                        <button onClick={() => setIsOpen(false)}><X size={20} /></button>
                    </div>

                    <div style={{ flex: 1, padding: '1rem', overflowY: 'auto', display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                        <div style={{ background: '#1e293b', padding: '0.75rem', borderRadius: '8px', fontSize: '0.9rem', alignSelf: 'flex-start', maxWidth: '80%' }}>
                            Hello! How can we help you build your dream PC today?
                        </div>
                    </div>

                    <div style={{ padding: '1rem', borderTop: '1px solid var(--border-color)', display: 'flex', gap: '0.5rem' }}>
                        <input
                            type="text"
                            placeholder="Type message..."
                            style={{ flex: 1, background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', padding: '0.5rem', color: '#fff' }}
                        />
                        <button className="neon-btn" style={{ padding: '0.5rem' }}><Send size={18} /></button>
                    </div>
                </div>
            ) : (
                <button
                    onClick={() => setIsOpen(true)}
                    className="neon-btn"
                    style={{ width: '60px', height: '60px', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center' }}
                >
                    <MessageSquare size={24} />
                </button>
            )}
        </div>
    )
}
