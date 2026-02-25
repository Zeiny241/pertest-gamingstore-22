import { DataTypes, Model } from 'sequelize';
import sequelize from '../config/database';
import User from './User';

class Order extends Model {
    public id!: number;
    public user_id!: number;
    public total_price!: number;
    public status!: string;
    public shipping_address!: string;
    public tracking_number!: string;
}

Order.init(
    {
        id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            primaryKey: true,
        },
        user_id: {
            type: DataTypes.INTEGER,
            references: {
                model: User,
                key: 'id',
            },
        },
        total_price: {
            type: DataTypes.DECIMAL(10, 2),
            allowNull: false,
        },
        status: {
            type: DataTypes.ENUM('Pending', 'Paid', 'Shipped', 'Delivered', 'Cancelled'),
            defaultValue: 'Pending',
        },
        shipping_address: {
            type: DataTypes.TEXT,
        },
        tracking_number: {
            type: DataTypes.STRING,
        },
    },
    {
        sequelize,
        modelName: 'Order',
        tableName: 'orders',
        timestamps: true,
        createdAt: 'created_at',
        updatedAt: false,
    }
);

Order.belongsTo(User, { foreignKey: 'user_id' });

export default Order;
