import { Router, Request, Response } from 'express';
import bcrypt from 'bcryptjs';
import jwt from 'jsonwebtoken';
import User from '../models/User';
import Role from '../models/Role';

const router = Router();

router.post('/register', async (req: Request, res: Response) => {
    try {
        const { username, email, password, fullname } = req.body;

        const existingUser = await User.findOne({ where: { email } });
        if (existingUser) {
            return res.status(400).json({ message: 'User already exists' });
        }

        const hashedPassword = await bcrypt.hash(password, 10);
        const userRole = await Role.findOne({ where: { name: 'user' } });

        const user = await User.create({
            username,
            email,
            password: hashedPassword,
            fullname,
            role_id: userRole?.id,
        });

        res.status(201).json({ message: 'User registered successfully' });
    } catch (error: any) {
        res.status(500).json({ message: error.message });
    }
});

router.post('/login', async (req: Request, res: Response) => {
    try {
        const { email, password } = req.body;
        const user = await User.findOne({
            where: { email },
            include: [Role]
        });

        if (!user || !(await bcrypt.compare(password, user.password))) {
            return res.status(401).json({ message: 'Invalid credentials' });
        }

        const token = jwt.sign(
            { id: user.id, username: user.username, role: (user as any).Role.name },
            process.env.JWT_SECRET || 'secret',
            { expiresIn: '24h' }
        );

        res.json({
            token,
            user: {
                id: user.id,
                username: user.username,
                email: user.email,
                fullname: user.fullname,
                role: (user as any).Role.name,
            }
        });
    } catch (error: any) {
        res.status(500).json({ message: error.message });
    }
});

export default router;
