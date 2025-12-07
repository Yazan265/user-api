# User Management API

A RESTful API built with Laravel 10 and JWT Authentication.
## Setup

1. Clone the repo
2. Run composer install
3. Run php artisan key:generate
4. Run php artisan jwt:secret
5. Run php artisan migrate
6. Serve: php artisan serve
## API Endpoints

### 1. Register
- URL: /api/auth/register
- Method: POST
- Body: - name: string (required)
    - email: email (required)
    - password: string (min 8, mixed case, numbers)
    - password_confirmation: string
    - role: admin/user (optional for testing)

### 2. Login
- URL: /api/auth/login
- Method: POST
- Body: email, password
- Response: Returns JWT Token.

### 3. List Users (Admin Only)
- URL: /api/auth/users
- Method: GET
- Header: Authorization: Bearer <token>

### 4. Update User
- URL: /api/auth/users/{id}
- Method: PUT
- Header: Authorization: Bearer <token>
## Web Routes Documentation
### 1. Authentication
Description	Route
Login page	GET /login
Login submit	POST /login
Register page	GET /register
Register submit	POST /register
Logout	POST /logout
### 2. Dashboard
GET /dashboard
### 3. Profile
Description	      Route
View profile	 GET /profile
Update profile	 POST /profile/update
Change password	 POST /profile/change-password
Delete account	 POST /profile/delete
### 4. User Management (Admin Only)
Description 	      Route
List users	        GET /users
View user	        GET /users/{id}
Create user form	GET /users/create
Store user	        POST /users
Edit user       	GET /users/{id}/edit
Update user	        PUT /users/{id}
Delete user	        DELETE /users/{id}
## Middleware
Middleware	         Purpose
auth	        Protects web routes
auth:api	    Requires JWT token
role:admin  	Allows only admin users
