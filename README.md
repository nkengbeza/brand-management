# 📦 Brand Toplist API & Frontend

A full-stack Laravel application for managing and displaying top-rated brands by country. Features a RESTful API, geolocation-based toplist, responsive frontend UI, and Docker-based development environment.

---

## 🌟 Features

- ✅ CRUD API for **brands**
- 🌐 Geolocation-aware toplist via `CF-IPCountry` header
- 🌍 Country management using ISO-2 codes
- 🧑‍💻 Mobile-friendly **frontend UI** (HTML & CSS)
- 🐳 **Dockerized** for local development
- 🌐 Pagination & language-ready
- 🧪 PHPUnit testing (SQLite-based)

---

## 🚀 Getting Started

### Prerequisites

- Docker + Docker Compose
- Git

### 🔧 Installation

```bash
# Clone the repository
git clone https://github.com/yourusername/brand-toplist.git
cd brand-toplist

# Copy environment file
cp .env.example .env

# Build and start containers
docker-compose up -d --build

# Install dependencies and run setup inside the container
docker-compose exec app composer install
docker-compose exec app php artisan migrate --seed

# 📦 Brand Toplist API & Frontend

A full-stack Laravel application for managing and displaying top-rated brands by country. Features a RESTful API, geolocation-based toplist, responsive frontend UI, and Docker-based development environment.

---

## 🌟 Features

- ✅ CRUD API for **brands**
- 🌐 Geolocation-aware toplist via `CF-IPCountry` header
- 🌍 Country management using ISO-2 codes
- 🧑‍💻 Mobile-friendly **frontend UI** (HTML & CSS)
- 🐳 **Dockerized** for local development
- 🌐 Pagination & language-ready
- 🧪 PHPUnit testing (SQLite-based)

---

## 🚀 Getting Started

### Prerequisites

- Docker + Docker Compose
- Git

### 🔧 Installation

```bash
# Clone the repository
git clone https://github.com/yourusername/brand-toplist.git
cd brand-toplist

# Copy environment file
cp .env.example .env

# Build and start containers
docker-compose up -d --build

# Install dependencies and run setup inside the container
docker-compose exec app composer install
docker-compose exec app php artisan migrate --seed
```


