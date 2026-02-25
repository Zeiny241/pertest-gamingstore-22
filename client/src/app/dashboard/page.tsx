export default function ProfilePage() {
    return (
        <div className="card">
            <h2 style={{ marginBottom: '2rem' }}>Account Profile</h2>
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '2rem' }}>
                <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                        <label>Full Name</label>
                        <input type="text" defaultValue="John Doe" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} />
                    </div>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                        <label>Email Address</label>
                        <input type="email" defaultValue="john@example.com" disabled style={{ padding: '0.75rem', background: '#0f172a', border: '1px solid var(--border-color)', borderRadius: '4px', color: 'var(--text-muted)' }} />
                    </div>
                    <button className="neon-btn" style={{ marginTop: '1rem' }}>Update Profile</button>
                </div>

                <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem', borderLeft: '1px solid var(--border-color)', paddingLeft: '2rem' }}>
                    <h3>Change Password</h3>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                        <label>Current Password</label>
                        <input type="password" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} />
                    </div>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
                        <label>New Password</label>
                        <input type="password" style={{ padding: '0.75rem', background: '#1e293b', border: '1px solid var(--border-color)', borderRadius: '4px', color: '#fff' }} />
                    </div>
                    <button style={{ padding: '0.75rem', border: '1px solid var(--border-color)', borderRadius: '4px' }}>Change Password</button>
                </div>
            </div>
        </div>
    )
}
