
# Experimental Dynamic & FullStack Portfolio

This project is a **Dynamic Portfolio Website** built using **PHP, MySQL, HTML, CSS, and JavaScript**. It is designed to showcase my skills, education, certificates, projects, and contact information. The project also includes an **Admin Panel** where I can manage all the content (CRUD operations) without editing the code directly.

---

## 🔑 Key Features

* **Frontend Portfolio**

  * Home / About Me section
  * Education & Qualifications
  * Certificates
  * Projects showcase
  * Contact Me form (messages stored in database)

* **Admin Panel**

  * Secure Login with username & password
  * Dashboard with cookie-based session handling
  * CRUD operations for:

    * Education
    * Certificates
    * Projects
  * Edit profile information
  * View & manage contact messages
  * Change password option

---

## 🛠️ Tech Stack

* **Frontend:** HTML, CSS, JavaScript
* **Backend:** PHP
* **Database:** MySQL
* **Authentication:** PHP sessions + cookies

---

## ⚙️ How to Run

1. Clone or download this repository into your `htdocs` (XAMPP) or `www` (WAMP) folder.
2. Import the `portfolio.sql` file into **phpMyAdmin** to create the database with predefined tables.
3. Update the `db.php` file (inside `includes/` or `config/`) with your database credentials:

   ```php
   $host = "localhost";
   $user = "root";
   $password = "";
   $dbname = "portfolio";
   ```
4. Start Apache & MySQL from XAMPP Control Panel.
5. Open browser and visit:

   * Portfolio → `http://localhost/portfolio`
   * Admin Panel → `http://localhost/admin`

---

## 📂 Project Structure

```
portfolio/
│── index.php            # Homepage
│
├── admin/               # Admin Panel
│   ├── login.php
│   ├── dashboard.php
│   ├── education_.php
│   ├── certificates.php
│   ├── projects.php
│   ├── logout.php
│   ├── education_edit.php
│   ├── project_edit.php
│   ├── certificate_edit.php
│   ├── change_password.php
│   ├── contacts.php
│   └── profile.php
│
├── includes/db.php      # Common files (db.php, header.php, footer.php)
├── assets/              # CSS, JS, Images
│   ├── css/
│   │   └── style.css
│   │
│   ├──images/
│   │   ├── images1.jpg
│   │   └── tech_stach.jpg
│   │
│   ├── js/
│   │   └── main.js
│   │
│   ├── certificates.php
├── process_contact.php  # To store messages and sender info in in sql and later show it in the admin panel contacts section
└── database.sql         # Database schema & sample data
```

---

## 📸 Screenshots

### Portfolio

![Portfolio Screenshot](https://github.com/AdnanHossain009/Testing-Portfolio-Project/blob/main/localhost_portfolio_new.png)

### Admin Panel

![Admin dashboard](https://github.com/AdnanHossain009/Testing-Portfolio-Project/blob/main/localhost_portfolio_admin_dashboard.php.png)

### Project Create Read Update Delete
![Project edit](https://github.com/AdnanHossain009/Testing-Portfolio-Project/blob/main/localhost_portfolio_admin_project_edit.php.png)

### Profile Edit
![Profile Edit](https://github.com/AdnanHossain009/Testing-Portfolio-Project/blob/main/localhost_portfolio_admin_profile.php.png)

### Messages
![Contacts list messages](https://github.com/AdnanHossain009/Testing-Portfolio-Project/blob/main/localhost_portfolio_admin_contacts.php.png)


---

## ✅ Future Improvements

* Add project filtering by category/skills
* Improve dashboard UI with charts
* Add email notifications for new contact messages
* Make portfolio multi-language supported


