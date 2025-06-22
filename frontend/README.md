# Frontend React (Vercel)

## Setup

1. Install dependencies:
   ```
   npm install
   ```
2. Copy `.env.example` ke `.env` dan isi `VITE_API_URL` dengan URL backend Railway:
   ```
   VITE_API_URL=https://NAMA-RAILWAY-APP.up.railway.app/api
   ```
3. Jalankan development server:
   ```
   npm run dev
   ```
4. Build untuk production:
   ```
   npm run build
   ```

## Deployment
- Deploy ke Vercel, gunakan build command: `npm run build` dan output: `dist`
- Pastikan environment variable `VITE_API_URL` di Vercel sudah di-set

## API Integration
- Semua request API menggunakan `src/services/api.js` (axios)
- Cek dan sesuaikan endpoint jika perlu

## Styling
- Menggunakan Tailwind CSS (lihat `tailwind.config.js`)

--- 