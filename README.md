# 📰 Blog System API

A clean and modular **Laravel REST API** for managing blog posts, categories, comments, and users.  
This API is built for frontend applications to easily connect and manage blog content.

---

## 🚀 Base URL

**Production** (Not Support)
```
https://test.com/api/v1
```

**Local Development**
```
http://localhost:8000/api/v1
```

---

## 🔑 Authentication

All private routes use **Bearer Token Authentication**.

**Example Header**
```
Authorization: Bearer {your_token}
```

---

## 📚 API Endpoints

### 🧍 User & Auth
| Method | Endpoint | Description | Auth | Test |
|:-------|:----------|:-------------|:------|:------|
| `POST` | `/auth/register` | Register a new user | No | No |
| `POST` | `/auth/login` | Login and get token | No | No |
| `GET` | `/auth/me` | Get authenticated user profile | Yes | No |
| `POST` | `/auth/logout` | Logout current user | Yes | No |

---

### 🏷️ Categories
| Method | Endpoint | Description | Auth | Test |
|:-------|:----------|:-------------|:------|:------|
| `GET` | `/categories` | Get all categories | No | Yes |
| `POST` | `/categories` | Create a new category | No | Yes |
| `PUT` | `/categories/{slug}` | Update category | No | Yes |
| `DELETE` | `/categories/{slug}` | Delete category | No | Yes |

---

## ⚙️ Installation (Backend Setup)

```bash
git clone https://github.com/yourname/blog-api.git
cd blog-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

---

## 🧑‍💻 Tech Stack

- **Laravel 12+**
- **PHP 8.4+**
- **Pgsql**
- **JWT / Passport Authentication**

---

## 👨‍🎨 Author

**Your Name**  
📧 your@email.com  
🔗 [GitHub](https://github.com/yourname) | [LinkedIn](https://linkedin.com/in/yourname)

---

## 🧾 License

This project is open-sourced under the **MIT License**.
