import { Router, Response } from 'express';
import { authenticateJWT } from '../middleware/auth';
import User from '../models/User';

const router = Router();

router.get('/profile', authenticateJWT, async (req: any, res: Response) => {
    try {
        const user = await User.findByPk(req.user.id, {
            attributes: { exclude: ['password'] }
        });
        res.json(user);
    } catch (error: any) {
        res.status(500).json({ message: error.message });
    }
});

router.put('/profile', authenticateJWT, async (req: any, res: Response) => {
    try {
        const { fullname, email } = req.body;
        const user = await User.findByPk(req.user.id);
        if (!user) return res.status(404).json({ message: 'User not found' });

        await user.update({ fullname, email });
        res.json({ message: 'Profile updated' });
    } catch (error: any) {
        res.status(400).json({ message: error.message });
    }
});

export default router;
