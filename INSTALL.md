# دليل التثبيت والتشغيل

هذا المشروع يمثل هيكل لوحة تحكم Laravel بدون الاعتماد على Node.js. لتشغيله يجب أولاً إنشاء مشروع Laravel جديد ثم نقل الملفات إليه.

## المتطلبات
- PHP 8.1+
- Composer
- MySQL أو MariaDB

## التثبيت محليًا
1. إنشاء مشروع Laravel جديد:
   ```bash
   composer create-project laravel/laravel delivery-app
   ```
2. نسخ الملفات الموجودة في هذا المستودع إلى مجلد المشروع الجديد (مع الاستبدال عند الطلب).
3. إعداد ملف البيئة:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. ضبط بيانات قاعدة البيانات داخل `.env`.
5. تشغيل المايجريشن:
   ```bash
   php artisan migrate
   ```
6. تشغيل السيرفر المحلي:
   ```bash
   php artisan serve
   ```

## التثبيت على الاستضافة المشتركة
1. أنشئ مشروع Laravel محليًا بنفس الخطوات السابقة.
2. ارفع جميع الملفات إلى الاستضافة في مجلد خارج `public_html` (مثلاً `app`).
3. انقل مجلد `public` إلى `public_html` أو اضبط Document Root عليه.
4. عدّل ملف `public_html/index.php` ليشير إلى مسار ملفات Laravel الصحيح:
   ```php
   require __DIR__.'/../app/vendor/autoload.php';
   $app = require_once __DIR__.'/../app/bootstrap/app.php';
   ```
5. ارفع ملف `.env` بعد ضبط إعدادات قاعدة البيانات.
6. شغّل المايجريشن من خلال SSH إن توفر:
   ```bash
   php artisan migrate --force
   ```

## ملاحظات مهمة
- لا يعتمد المشروع على npm أو Node.js.
- تأكد من صلاحيات مجلدات `storage` و `bootstrap/cache`.
