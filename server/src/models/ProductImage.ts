import { DataTypes, Model } from 'sequelize';
import sequelize from '../config/database';
import Product from './Product';

class ProductImage extends Model {
    public id!: number;
    public product_id!: number;
    public image_url!: string;
    public is_main!: boolean;
}

ProductImage.init(
    {
        id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            primaryKey: true,
        },
        product_id: {
            type: DataTypes.INTEGER,
            references: {
                model: Product,
                key: 'id',
            },
        },
        image_url: {
            type: DataTypes.STRING,
            allowNull: false,
        },
        is_main: {
            type: DataTypes.BOOLEAN,
            defaultValue: false,
        },
    },
    {
        sequelize,
        modelName: 'ProductImage',
        tableName: 'product_images',
        timestamps: false,
    }
);

Product.hasMany(ProductImage, { foreignKey: 'product_id' });
ProductImage.belongsTo(Product, { foreignKey: 'product_id' });

export default ProductImage;
