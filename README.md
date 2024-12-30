# Laravel and Vue.js Application Setup with Inertia.js

This README provides step-by-step instructions to set up and run a Laravel and Vue.js application integrated with Inertia.js.

## Prerequisites
Before you start, ensure that the following software is installed on your machine:

1. **PHP** (>= 8.0 recommended)
2. **Composer**
3. **Node.js** (>= 14.x recommended) and **npm**
4. **MySQL** (Database)
5. **Laravel Installer** (optional but recommended)

---

## Setting Up the Application

### 1. Clone the Repository
```bash
git clone https://github.com/DavidzMwangi/TaskManager.git
cd TaskManager
```

### 2. Install PHP Dependencies
Run the following command to install Laravel's dependencies:
```bash
composer install
```

### 3. Set Up the Environment File
Copy the `.env.example` file to `.env` and configure your environment variables:
```bash
cp .env.example .env
```

Update the `.env` file with your MySQL database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 4. Generate Application Key
Run the command below to generate a new application key:
```bash
php artisan key:generate
```

### 5. Install JavaScript Dependencies
Run the following command to install the required JavaScript packages:
```bash
npm install
```

### 6. Build Frontend Assets
Compile the assets using the following command:
```bash
npm run dev
```
For production builds, use:
```bash
npm run build
```

### 7. Run Database Migrations
Ensure your MySQL database is set up, then run:
```bash
php artisan migrate
```

If the application includes seeded data, run:
```bash
php artisan db:seed
```

---

## Running the Application

### 1. Start the Laravel Development Server
Use the following command to start the backend server:
```bash
php artisan serve
```
By default, the application will be accessible at [http://localhost:8000](http://localhost:8000).

### 2. Start the Vite Development Server
In another terminal, start the Vite server to compile and serve frontend assets:
```bash
npm run dev
```

By default, Vite will serve assets at [http://localhost:5173](http://localhost:5173).

---

## Accessing the Application
Once both servers are running:
- Visit [http://localhost:8000](http://localhost:8000) to access the Laravel backend.
- The frontend assets will be loaded dynamically from the Vite development server.

---

## Additional Commands

### Clear Cache
If you encounter issues with configuration or routes, clear the cache:
```bash
php artisan config:cache
php artisan route:cache
```

### Stop Development Servers
To stop the servers, press `CTRL+C` in the respective terminal windows.

---

## Notes
- Ensure proper permissions are set for the `storage` and `bootstrap/cache` directories:
  ```bash
  chmod -R 775 storage bootstrap/cache
  ```
- Ensure your MySQL database is created and configured in the `.env` file.
- For production deployment, use `npm run build` and a proper web server like Nginx or Apache.
- There is an `api.http` file in the project that contains sample API requests. You can use this file to test the application's APIs. Below is an example of how the file looks:

```
### POST create a new task
POST http://localhost:8000/api/tasks
Accept: application/json
Content-Type: application/json

{
  "title": "Task 1",
  "description": "Description 1"
}

### GET get all tasks
GET http://localhost:8000/api/tasks
Accept: application/json
Content-Type: application/json


### GET get a single task
GET http://localhost:8000/api/tasks/1
Accept: application/json
Content-Type: application/json


### PUT update a single task
PUT http://localhost:8000/api/tasks/1
Accept: application/json
Content-Type: application/json

{
  "title": "Task 1",
  "description": "Description 1"
}

### DELETE a single task
DELETE http://localhost:8000/api/tasks/1
Accept: application/json
Content-Type: application/json
```

---


