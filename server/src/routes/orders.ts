import { Router, Response } from 'express';
import { authenticateJWT } from '../middleware/auth';
import Order from '../models/Order';
import OrderItem from '../models/OrderItem';
import Product from '../models/Product';
import Payment from '../models/Payment';
import sequelize from '../config/database';

const router = Router();

router.post('/', authenticateJWT, async (req: any, res: Response) => {
    const t = await sequelize.transaction();
    try {
        const { items, shipping_address, payment_method } = req.body;
        let total_price = 0;

        const order = await Order.create({
            user_id: req.user.id,
            total_price: 0,
            shipping_address,
            status: 'Pending'
        }, { transaction: t });

        for (const item of items) {
            const product = await Product.findByPk(item.product_id);
            if (!product || product.stock < item.quantity) {
                throw new Error(`Product ${item.product_id} is out of stock or invalid`);
            }

            const itemPrice = Number(product.price) * item.quantity;
            total_price += itemPrice;

            await OrderItem.create({
                order_id: order.id,
                product_id: item.product_id,
                quantity: item.quantity,
                price: product.price
            }, { transaction: t });

            await product.decrement('stock', { by: item.quantity, transaction: t });
        }

        await order.update({ total_price }, { transaction: t });

        await Payment.create({
            order_id: order.id,
            payment_method,
            payment_status: 'Pending'
        }, { transaction: t });

        await t.commit();

        // Logic for PromptPay QR generation could go here
        let payment_data = {};
        if (payment_method === 'PromptPay') {
            payment_data = {
                qr_code: `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=PROMPTPAY_PAYLOAD_FOR_${total_price}`,
                amount: total_price
            };
        }

        res.status(201).json({
            message: 'Order created successfully',
            order_id: order.id,
            payment_data
        });
    } catch (error: any) {
        await t.rollback();
        res.status(400).json({ message: error.message });
    }
});

router.get('/my-orders', authenticateJWT, async (req: any, res: Response) => {
    try {
        const orders = await Order.findAll({
            where: { user_id: req.user.id },
            include: [
                { model: OrderItem, include: [Product] },
                Payment
            ],
            order: [['created_at', 'DESC']]
        });
        res.json(orders);
    } catch (error: any) {
        res.status(500).json({ message: error.message });
    }
});

export default router;
