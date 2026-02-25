# Installation & Deployment Guide

## Prerequisites
- Docker & Docker Compose installed on your system.
- Stripe account (for payments).

## Quick Start (Docker)
1. Clone the repository.
2. Navigate to the project root.
3. Run `docker-compose up -d --build`.
4. Access the frontend at `http://localhost:3000`.
5. Access the backend API at `http://localhost:5000`.
6. Access phpMyAdmin at `http://localhost:8081`.

## Deployment (VPS / Shared Hosting)

### 1. Using Docker (Recommended)
- Simply install Docker on your VPS.
- Transfer the code.
- Run `docker-compose up -d`.

### 2. Manual Deployment (Node.js Environment)
- **Backend**:
  - Point your domain/subdomain to the `server` directory.
  - Run `npm install` and `npm run build`.
  - Use PM2 to manage the process: `pm2 start dist/index.js`.
- **Frontend**:
  - Use Vercel (highly recommended for Next.js) or a custom Node.js server.
  - Run `npm run build` and `npm start`.

## Admin Default Login
- **Username**: `admin`
- **Password**: `1234`
- Note: This is seeded during the initial database creation.

## Environment Variables
Ensure you update the following in `.env` files:
- `JWT_SECRET`
- `DB_HOST`, `DB_USER`, `DB_PASSWORD`, `DB_NAME`
- `STRIPE_SECRET_KEY` (if using actual payments)
