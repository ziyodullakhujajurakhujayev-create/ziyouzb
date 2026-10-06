# LUX YAN TEX ERP

PHP 8.3 + MySQL asosidagi zamonaviy ichki korxona boshqaruv tizimi. Bu loyiha ishlab chiqarish, ombor, sifat nazorati, rulonlar, traceability, hisobotlar va AI maslahatlar modulini o‘z ichiga oladi.

## Xususiyatlar

- Admin, rahbar, operator, sifat nazorati, ombor, ishlab chiqarish rollari
- Ishlab chiqarish, xomashyo va ombor nazorati
- Avtomatik rulon raqam va QR-kod yaratish
- Sifat nazorati va nuqsonlar
- Real-time bildirishnomalar
- Excel/PDF export
- Audit log va tarix
- Responsive dashboard
- AI-dan tavsiyalar

## Tezkor boshlash

1. MySQL ma’lumotlar bazasini yarating:

```sql
CREATE DATABASE lux_yan_tex_erp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Schema va seed fayllarni yuklang:

```bash
mysql -u root -p lux_yan_tex_erp < database/schema.sql
mysql -u root -p lux_yan_tex_erp < database/seed.sql
```

3. `.env.example` dan `.env` yarating yoki environment sozlamalarni moslashtiring.

4. PHP built-in serverni ishga tushiring:

```bash
php -S localhost:8000 public/index.php
```

5. Brauzerda kirish:

```text
http://localhost:8000/login
```

### Demo login

- Username: `admin@luxyantex.local`
- Password: `admin123`

## Loyiha strukturasi

```text
app/
  Controllers/
  Core/
  Models/
  Services/
  resources/views/
public/
  assets/
  index.php
database/
  schema.sql
  seed.sql
```

## Muhim

Bu loyiha professional ERP uchun ishlaydigan MVP bazasi bo‘lib, keyinchalik quyidagi kengaytmalar qo‘shilishi mumkin:

- barcodes and scanner integration
- mobile app sync
- 1C / SAP exchange
- advanced dashboards and BI
- multi-company support
- queue and scheduling automation

## Litsenziya

MIT
