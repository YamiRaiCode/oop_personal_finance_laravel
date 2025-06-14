# Personal Finance Manager 💸

A Laravel-based web application designed for tracking and managing personal finances, developed as part of a university practice project..

## 🎯 Objective

The aim of this project is to help users manage their **personal income and expenses**, visualize financial data, and make better budgeting decisions. This system allows the creation, editing, and deletion of categorized financial entries along with real-time reporting features.

## ⚙️ Features

- 🔐 **User Authentication** (Laravel Breeze)
- ➕ Add, 🖊️ Edit, ❌ Delete income and expense entries
- 🗂️ Select categories from classifiers (e.g., *Food*, *Fuel*, *Salary*, etc.)
- ⚙️ Manage categories (add/edit/delete)
- 💰 Real-time balance: total income, total expenses, and net balance
- 📊 Reports:
  - Period-based reports
  - Category-based summary
  - Financial analysis (min, max, average)
- 🌐 Clean and responsive dashboard interface

## 🛠️ Technologies Used

- **PHP 8.x**
- **Laravel 11**
- **Laravel Breeze** (Blade + Alpine stack)
- **MySQL** 
- **Tailwind CSS** (with Blade templates)
- **Git** + **GitHub** for version control

## 🧱 Database Structure

- Tables:
  - `users`
  - `categories`
  - `transactions` *(income & expenses stored with category, amount, date, description, type)*
- Relationships:
  - `users` → `transactions` (1-to-many)
  - `transactions` → `categories` (many-to-1)

📌 Detailed UML class and DB diagrams can be found in the `/docs` folder or attached to the practice report.

## 📸 Screenshots

**Will be added when the project is completed**

- Login/Register Page  
- Dashboard with charts and summary  
- Transaction management page  
- Category management  

## 🗃️ Installation

Clone the repo and run:

```bash
git clone https://github.com/YamiRaiCode/oop_personal_finance_laravel.git
cd oop_personal_finance_laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

