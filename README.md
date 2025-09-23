# Recruitment Platform API

A Laravel-based REST API for managing job applications, recruiters, and candidates.

## Overview

This platform facilitates the recruitment process by managing:

-   Job postings by recruiters
-   Candidate applications
-   Application status tracking
-   Multi-stage recruitment process

## Features

-   **Authentication**
    -   Separate auth for recruiters and candidates
    -   Token-based authentication using Sanctum
-   **Recruiters**

    -   Create and manage job postings
    -   Track applications
    -   Update application stages
    -   Manage profile

-   **Candidates**

    -   Apply for jobs
    -   Upload resumes
    -   Track application status
    -   Manage profile

-   **Application Stages**

    -   Applied
    -   Phone Screen
    -   Interview
    -   Hired
    -   Rejected

-   **Zoom Integration**

This platform includes an integration with Zoom Meetings:

-   Recruiters can automatically create a Zoom meeting when moving an application stage to Interview.
-   Candidates receive the meeting details and can join directly.
-   This feature helps streamline interview scheduling and reduces manual work.

## Requirements

-   PHP >= 8.2
-   MySQL >= 5.7
-   Composer
-   Laravel 12.x

## Installation

1. Clone the repository:

```bash
git clone https://github.com/amr-94/ATS.git
cd recruiter2
```

2. Install dependencies:

```bash
composer install
```

3. Create environment file:

```bash
cp .env.example .env
```

4. Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=recruiter2
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Generate application key:

```bash
php artisan key:generate
```

6. Run migrations:

```bash
php artisan migrate
```

7. Create storage link for resumes:

```bash
php artisan storage:link
```

## API Endpoints

### Auth Routes

```
POST /api/v1/recruiter/auth/register
POST /api/v1/recruiter/auth/login
POST /api/v1/candidate/auth/register
POST /api/v1/candidate/auth/login
```

### Protected Routes

```
# Recruiter Routes
GET    /api/v1/recruiter/jobs
POST   /api/v1/recruiter/jobs
PUT    /api/v1/recruiter/jobs/{id}
DELETE /api/v1/recruiter/jobs/{id}
PUT    /api/v1/recruiter/applications/{id}/stage

# Candidate Routes
GET    /api/v1/candidate/jobs
POST   /api/v1/candidate/jobs/{job}/apply
GET    /api/v1/candidate/applications
```

## Authentication

The API uses Laravel Sanctum for authentication. Include the token in requests:

```
Authorization: Bearer {your_token}
```

## File Storage

Resumes are stored in `storage/app/public/resumes`. Make sure this directory is writable.

## Error Handling

The API returns consistent error responses:

```json
{
    "status": "error",
    "message": "Error description",
    "code": 400
}
```

## Success Responses

Successful responses follow this format:

```json
{
    "status": "success",
    "message": "Operation successful",
    "data": {}
}
```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License.
