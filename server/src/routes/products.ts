import { Router, Request, Response } from 'express';
import { Op } from 'sequelize';
import Product from '../models/Product';
import Category from '../models/Category';
import ProductImage from '../models/ProductImage';

const router = Router();

router.get('/', async (req: Request, res: Response) => {
    try {
        const { category, search, minPrice, maxPrice, brand, sort } = req.query;
        const where: any = {};

        if (category) where.category_id = category;
        if (brand) where.brand = brand;
        if (search) {
            where.name = { [Op.like]: `%${search}%` };
        }
        if (minPrice || maxPrice) {
            where.price = {};
            if (minPrice) where.price[Op.gte] = minPrice;
            if (maxPrice) where.price[Op.lte] = maxPrice;
        }

        let order: any = [['created_at', 'DESC']];
        if (sort === 'price_asc') order = [['price', 'ASC']];
        if (sort === 'price_desc') order = [['price', 'DESC']];
        if (sort === 'rating') order = [['rating', 'DESC']];

        const products = await Product.findAll({
            where,
            include: [
                { model: Category, attributes: ['name'] },
                { model: ProductImage, where: { is_main: true }, required: false }
            ],
            order,
        });

        res.json(products);
    } catch (error: any) {
        res.status(500).json({ message: error.message });
    }
});

router.get('/:id', async (req: Request, res: Response) => {
    try {
        const product = await Product.findByPk(req.params.id, {
            include: [Category, ProductImage],
        });

        if (!product) {
            return res.status(404).json({ message: 'Product not found' });
        }

        res.json(product);
    } catch (error: any) {
        res.status(500).json({ message: error.message });
    }
});

router.get('/search/suggestions', async (req: Request, res: Response) => {
    try {
        const { query } = req.query;
        if (!query) return res.json([]);

        const suggestions = await Product.findAll({
            where: {
                name: { [Op.like]: `%${query}%` }
            },
            attributes: ['id', 'name'],
            limit: 5
        });

        res.json(suggestions);
    } catch (error: any) {
        res.status(500).json({ message: error.message });
    }
});

export default router;
