import ProductCard from '@/components/ProductCard'

export default function Home() {
    const featuredProducts = [
        { id: 1, name: 'NVIDIA RTX 5090 FE', price: 1999, brand: 'NVIDIA', rating: 4.9 },
        { id: 2, name: 'AMD Ryzen 9 9950X', price: 649, brand: 'AMD', rating: 4.8 },
        { id: 3, name: 'Corsair Dominator Titanium 64GB', price: 299, brand: 'Corsair', rating: 4.7 },
        { id: 4, name: 'Samsung 990 Pro 4TB', price: 349, brand: 'Samsung', rating: 4.9 },
    ]

    return (
        <main>
            {/* Hero Section */}
            <section style={{ padding: '6rem 0', background: 'radial-gradient(circle at center, #1a1b26 0%, #0a0b10 100%)', textAlign: 'center' }}>
                <div className="container">
                    <h1 style={{ fontSize: '4rem', marginBottom: '1.5rem', background: 'linear-gradient(to right, #00d2ff, #7000ff)', WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent' }}>
                        UNLEASH TRUE PERFORMANCE
                    </h1>
                    <p style={{ fontSize: '1.25rem', color: 'var(--text-muted)', maxWidth: '700px', margin: '0 auto 2.5rem' }}>
                        Experience the next generation of gaming hardware. Premium components for elite builders.
                    </p>
                    <div style={{ display: 'flex', gap: '1rem', justifyContent: 'center' }}>
                        <button className="neon-btn" style={{ padding: '1rem 2.5rem', fontSize: '1.1rem' }}>Shop Now</button>
                        <button style={{ border: '1px solid var(--border-color)', padding: '1rem 2.5rem', borderRadius: '4px', fontWeight: '600' }}>Build PCs</button>
                    </div>
                </div>
            </section>

            {/* Featured Products */}
            <section style={{ padding: '4rem 0' }}>
                <div className="container">
                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end', marginBottom: '2.5rem' }}>
                        <div>
                            <h2 style={{ fontSize: '2rem' }}>Featured Products</h2>
                            <p style={{ color: 'var(--text-muted)' }}>Hot picks of the week</p>
                        </div>
                        <button style={{ color: 'var(--primary-color)', fontWeight: 'bold' }}>View All →</button>
                    </div>

                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(250px, 1fr))', gap: '2rem' }}>
                        {featuredProducts.map(product => (
                            <ProductCard key={product.id} product={product} />
                        ))}
                    </div>
                </div>
            </section>

            {/* Flash Sale Banner */}
            <section className="container" style={{ marginBottom: '4rem' }}>
                <div className="card" style={{ background: 'linear-gradient(135deg, #7000ff 0%, #00d2ff 100%)', color: '#000', padding: '3rem', textAlign: 'center', position: 'relative', overflow: 'hidden' }}>
                    <div style={{ position: 'relative', zIndex: 1 }}>
                        <h2 style={{ fontSize: '2.5rem', marginBottom: '1rem' }}>FLASH SALE: 30% OFF</h2>
                        <p style={{ fontSize: '1.2rem', marginBottom: '2rem' }}>Limited time offers on selection GPUs and SSDs. Don't miss out!</p>
                        <div style={{ display: 'flex', gap: '1rem', justifyContent: 'center' }}>
                            <div style={{ background: '#000', color: '#fff', padding: '1rem', borderRadius: '8px', minWidth: '80px' }}>
                                <span style={{ display: 'block', fontSize: '1.5rem', fontWeight: 'bold' }}>02</span>
                                <span style={{ fontSize: '0.8rem' }}>HOURS</span>
                            </div>
                            <div style={{ background: '#000', color: '#fff', padding: '1rem', borderRadius: '8px', minWidth: '80px' }}>
                                <span style={{ display: 'block', fontSize: '1.5rem', fontWeight: 'bold' }}>45</span>
                                <span style={{ fontSize: '0.8rem' }}>MINS</span>
                            </div>
                            <div style={{ background: '#000', color: '#fff', padding: '1rem', borderRadius: '8px', minWidth: '80px' }}>
                                <span style={{ display: 'block', fontSize: '1.5rem', fontWeight: 'bold' }}>12</span>
                                <span style={{ fontSize: '0.8rem' }}>SECS</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    )
}
