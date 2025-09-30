# 🚀 GUVI Login System

[![PHP](https://img.shields.io/badge/PHP-8.1-blue)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8-blue)](https://www.mysql.com/)
[![Redis](https://img.shields.io/badge/Redis-6-orange)](https://redis.io/)
[![Docker](https://img.shields.io/badge/Docker-20.10-blue)](https://www.docker.com/)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

A **PHP login and registration system** using MySQL and Redis, designed for secure user authentication and session management with a fully Dockerized setup for easy deployment.

---

## 📌 Features

* User registration with hashed passwords
* User login with secure password verification
* Session management using Redis
* Error handling and JSON API responses
* Dockerized setup for seamless deployment

---

## 🛠 Technologies Used

* **PHP 8.1**
* **MySQL 8**
* **Redis**
* **Docker & Docker Compose**
* **Nginx**

---

## ⚙️ Setup Instructions

1. **Clone the repository**

   ```bash
   git clone https://github.com/yourusername/guvi-login-system.git
   cd guvi-login-system
   ```

2. **Start Docker containers**

   ```bash
   docker-compose up -d
   ```

3. **Import the database schema**

   ```bash
   Get-Content schema.sql | docker exec -i guvi-mysql mysql -u root -prootpassword guvi
   ```

4. **Access the app**

   * [Register](http://localhost:8080/register.html)
   * [Login](http://localhost:8080/login.html)

---

## 📂 Folder Structure

```
project-root/
├── php/
│   ├── register.php
│   ├── login.php
│   ├── db.php
│   └── redis_helper.php
├── schema.sql
├── docker-compose.yml
├── README.md
└── ...
```

---

## 🛠 Troubleshooting

* If you see a **500 Internal Server Error**, check PHP logs:

  ```bash
  docker-compose logs php
  ```
* Ensure no whitespace exists before `<?php` in PHP files.
* Confirm all Docker containers are running:

  ```bash
  docker ps
  ```

---

## 📖 License

This project is open source and available under the [MIT License](LICENSE).

---

## 🎯 Project Description

A PHP login and registration system using MySQL for storage and Redis for session caching. Fully Dockerized with PHP-FPM, Nginx, MySQL, and Redis for secure, fast, and scalable authentication.
