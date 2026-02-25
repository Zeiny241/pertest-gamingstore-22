import { DataTypes, Model } from 'sequelize';
import sequelize from '../config/database';
import Order from './Order';

class Payment extends Model {
    public id!: number;
    public order_id!: number;
    public payment_method!: string;
    public payment_status!: string;
    public slip_url!: string;
    public transaction_id!: string;
}

Payment.init(
    {
        id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            primaryKey: true,
        },
        order_id: {
            type: DataTypes.INTEGER,
            references: {
                model: Order,
                key: 'id',
            },
        },
        payment_method: {
            type: DataTypes.STRING,
            allowNull: false,
        },
        payment_status: {
            type: DataTypes.STRING,
            defaultValue: 'Pending',
        },
        slip_url: {
            type: DataTypes.STRING,
        },
        transaction_id: {
            type: DataTypes.STRING,
        },
    },
    {
        sequelize,
        modelName: 'Payment',
        tableName: 'payments',
        timestamps: true,
        createdAt: 'created_at',
        updatedAt: false,
    }
);

Order.hasOne(Payment, { foreignKey: 'order_id' });
Payment.belongsTo(Order, { foreignKey: 'order_id' });

export default Payment;
