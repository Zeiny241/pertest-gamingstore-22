import { Router, Response } from 'express';
import { authenticateJWT, authorizeRole } from '../middleware/auth';
import Product from '../models/Product';
import Order from '../models/Order';
import User from '../models/User';
import Category from '../models/Category';
import Payment from '../models/Payment';
import { Op } from 'sequelize';

const router = Router();

// Products Management
router.post('/products', authenticateJWT, authorizeRole(['admin']), async (req: any, res: Response) => {
    try {
        const product = await Product.create(req.body);
        res.status(201).json(product);
    } catch (error: any) {
        res.status(400).json({ message: error.message });
    }
});

router.put('/products/:id', authenticateJWT, authorizeRole(['admin']), async (req: any, res: Response) => {
    try {
        const product = await Product.findByPk(req.params.id);
        if (!product) return res.status(404).json({ message: 'Product not found' });
        await product.update(req.body);
        res.json(product);
    } catch (error: any) {
        res.status(400).json({ message: error.message });
    }
});

// Orders Management
router.get('/orders', authenticateJWT, authorizeRole(['admin']), async (req: any, res: Response) => {
    try {
        const orders = await Order.findAll({
            include: [User, Payment]
        });
        res.json(orders);
    } catch (error: any) {
        res.status(500).json({ message: error.message });
    }
});

router.put('/orders/:id/status', authenticateJWT, authorizeRole(['admin']), async (req: any, res: Response) => {
    try {
        const { status, tracking_number } = req.body;
        const order = await Order.findByPk(req.params.id);
        if (!order) return res.status(404).json({ message: 'Order not found' });

        await order.update({ status, tracking_number });
        res.json(order);
    } catch (error: any) {
        res.status(400).json({ message: error.message });
    }
});

// Analytics
router.get('/analytics/sales', authenticateJWT, authorizeRole(['admin']), async (req: any, res: Response) => {
    try {
        const totalSales = await Order.sum('total_price', {
            where: { status: 'Paid' }
        });
        const orderCount = await Order.count();
        const userCount = await User.count();

        res.json({ totalSales, orderCount, userCount });
    } catch (error: any) {
        res.status(500).json({ message: error.message });
    }
});

export default router;
