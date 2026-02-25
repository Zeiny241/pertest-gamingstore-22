import { DataTypes, Model } from 'sequelize';
import sequelize from '../config/database';
import Role from './Role';

class User extends Model {
    public id!: number;
    public username!: string;
    public email!: string;
    public password!: string;
    public fullname!: string;
    public role_id!: number;
    public verified!: boolean;
    public readonly created_at!: Date;
}

User.init(
    {
        id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            primaryKey: true,
        },
        username: {
            type: DataTypes.STRING,
            allowNull: false,
            unique: true,
        },
        email: {
            type: DataTypes.STRING,
            allowNull: false,
            unique: true,
        },
        password: {
            type: DataTypes.STRING,
            allowNull: false,
        },
        fullname: {
            type: DataTypes.STRING,
        },
        role_id: {
            type: DataTypes.INTEGER,
            references: {
                model: Role,
                key: 'id',
            },
        },
        verified: {
            type: DataTypes.BOOLEAN,
            defaultValue: false,
        },
    },
    {
        sequelize,
        modelName: 'User',
        tableName: 'users',
        timestamps: true,
        createdAt: 'created_at',
        updatedAt: false,
    }
);

User.belongsTo(Role, { foreignKey: 'role_id' });

export default User;
