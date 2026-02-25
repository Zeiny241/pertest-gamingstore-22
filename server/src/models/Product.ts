import { DataTypes, Model } from 'sequelize';
import sequelize from '../config/database';
import Category from './Category';

class Product extends Model {
    public id!: number;
    public category_id!: number;
    public name!: string;
    public description!: string;
    public price!: number;
    public stock!: number;
    public brand!: string;
    public rating!: number;
}

Product.init(
    {
        id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            primaryKey: true,
        },
        category_id: {
            type: DataTypes.INTEGER,
            references: {
                model: Category,
                key: 'id',
            },
        },
        name: {
            type: DataTypes.STRING,
            allowNull: false,
        },
        description: {
            type: DataTypes.TEXT,
        },
        price: {
            type: DataTypes.DECIMAL(10, 2),
            allowNull: false,
        },
        stock: {
            type: DataTypes.INTEGER,
            defaultValue: 0,
        },
        brand: {
            type: DataTypes.STRING,
        },
        rating: {
            type: DataTypes.DECIMAL(3, 2),
            defaultValue: 0,
        },
    },
    {
        sequelize,
        modelName: 'Product',
        tableName: 'products',
        timestamps: true,
        createdAt: 'created_at',
        updatedAt: false,
    }
);

Product.belongsTo(Category, { foreignKey: 'category_id' });

export default Product;
