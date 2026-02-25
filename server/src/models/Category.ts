import { DataTypes, Model } from 'sequelize';
import sequelize from '../config/database';

class Category extends Model {
    public id!: number;
    public name!: string;
    public description!: string;
}

Category.init(
    {
        id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            primaryKey: true,
        },
        name: {
            type: DataTypes.STRING,
            allowNull: false,
        },
        description: {
            type: DataTypes.TEXT,
        },
    },
    {
        sequelize,
        modelName: 'Category',
        tableName: 'categories',
        timestamps: true,
        createdAt: 'created_at',
        updatedAt: false,
    }
);

export default Category;
