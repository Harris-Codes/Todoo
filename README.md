# Todoo

<p align="center">
  <img src="https://laravel.com/img/logotype.min.svg" alt="Laravel Logo" width="300">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10-red?logo=laravel">
  <img src="https://img.shields.io/badge/PHP-8.2-blue?logo=php">
  <img src="https://img.shields.io/badge/license-MIT-green">
  <img src="https://img.shields.io/badge/status-Active-brightgreen">
</p>

Gamified classroom system with quizzes, assignments, and badges built with Laravel and Kotlin companion app.

---

## 🚀 Features

✅ Role-based dashboards for teachers and students  
✅ Quiz system with auto-scoring and leaderboards  
✅ Assignment upload and grading  
✅ Badges for gamification  
✅ Clean, responsive UI

---

## 🖥️ Screenshots

### 🖼️ Login Page
![Login Page](images/screenshots/loginpage.png)

### 🖼️ Homepage
![Homepage](images/screenshotshomepage.png)

### 🖼️ Classroom View
![Classroom View](images/screenshotsclassroom.png)

### 🖼️ Class Overview
![Class Overview](images/screenshotsclassoverview.png)

### 🖼️ Quiz Attempt
![Quiz Attempt](images/screenshotsquiz.png)

### 🖼️ Badge Earned Popup
![Badge Earned](images/screenshotsBadgeEarned.png)


---

## 🛠️ Full Setup

### 1️⃣ Prerequisites

✅ **VS Code** with recommended extensions:
- PHP Intelephense
- Laravel Blade Snippets
- Prettier
- GitLens (optional)

✅ **XAMPP**
- Start Apache and MySQL.
- Access `localhost/phpmyadmin`.

✅ **Git**

```bash
git config --global user.name "Your Name"
git config --global user.email "your-email@example.com"
git --version
```

✅ **Composer**

Ensure it points to `C:\xampp\php\php.exe`.

```bash
composer --version
```

✅ **Node.js & npm**

```bash
node --version
npm --version
```

---

### 2️⃣ Project Setup

✅ **Clone the Repository**

```bash
cd C:\xampp\htdocs
git clone https://github.com/Harris-Codes/Todoo.git
cd Todoo
```

✅ **Install PHP Dependencies**

```bash
composer install
```

✅ **Install Node Dependencies & Build Assets**

```bash
npm install
npm run build
```

✅ **Copy & Configure Environment File**

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todoo
DB_USERNAME=root
DB_PASSWORD=
```

Create the `todoo` database in phpMyAdmin.

✅ **Run Migrations & Seeders**

```bash
php artisan migrate --seed
```

✅ **Create Storage Symlink**

```bash
php artisan storage:link
```

✅ **Run the Server**

```bash
php artisan serve
```

Visit [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

### 3️⃣ (Optional) Development Tools

✅ **Laravel Debugbar**

```bash
composer require barryvdh/laravel-debugbar --dev
```

✅ Use for live reload while developing:

```bash
npm run dev
```

---

## 🚫 No Contributions Accepted

Thank you for your interest, but this repository does not accept pull requests.

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

## 📫 Contact

Developed by **Muhammad Harris Iqmal**  
[GitHub](https://github.com/Harris-Codes) | [Email](mailto:muhdharris9901@gmail.com)

---

> 🚀 Feel free to fork, star, and contribute to improve **Todoo** further!
