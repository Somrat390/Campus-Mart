
Live Demo: https://campus-mart-3.onrender.com

# 🚀 Campus-Mart

**Campus-Mart** is a secure, localized peer-to-peer re-commerce platform built specifically for university students. It allows students to buy, sell, and trade items like textbooks, electronics, and lab equipment within their verified campus community.



## 🌟 Key Features

- **Domain-Restricted Access:** Only users with a valid university email (e.g., `@diu.edu.bd`) can register.
- **Dual Verification:** Includes Email OTP verification and manual Student ID card review.
- **Real-Time Chat:** Integrated **Pusher (WebSockets)** for instant messaging between buyers and sellers.
- **Cloud Media Hosting:** Uses **Cloudinary** for high-performance product image and ID storage.
- **Admin Dashboard:** A private panel for managing users, verifying identities, and moderating listings.
- **Responsive UI:** Built with **Tailwind CSS** for a mobile-first, "animatic" user experience.

## 🛠️ Tech Stack

- **Framework:** [Laravel 11](https://laravel.com) (PHP 8.2+)
- **Frontend:** Tailwind CSS, Alpine.js
- **Database:** PostgreSQL (Hosted on Render)
- **Real-Time:** Pusher
- **Cloud Storage:** Cloudinary
- **Deployment:** Render

## ⚙️ Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/campus-mart.git
   cd campus-mart
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configure Environment:**
   Copy `.env.example` to `.env` and configure your credentials:
   - Database (PostgreSQL)
   - Pusher (App ID, Key, Secret, Cluster)
   - Cloudinary (Cloud URL, API Key, Secret)

4. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

5. **Start the server:**
   ```bash
   php artisan serve
   ```

## 🛡️ Administrative Access

The system utilizes custom middleware to restrict access to the Admin Panel. By default, the first user (ID 1) is granted administrative privileges to verify or delete users and moderate the marketplace.

## 📄 License

This project was developed for academic purposes at Daffodil International University.

---
