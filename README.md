# CargoTrace_Laravel

Backend REST API for shipment tracking and logistics management built with **Laravel**, **Laravel Sanctum** token-based authentication, and **TiDB Cloud** as the database backend. The repository also includes **Postman** API collections and environments (`CargoTrace API Tests` and `CargoTrace Local`) for endpoint verification and CRUD lifecycle testing.

## Overview
`CargoTrace_Laravel` provides authenticated RESTful endpoints to manage and track shipments, including payload validation, controlled shipment status transitions, relational data retrieval, and test data cleanup.

## Tech Stack & Infrastructure
- **Backend Framework:** Laravel (local development server via `php artisan serve`)
- **Authentication:** Laravel Sanctum (Bearer Token authentication)
- **Database:** TiDB Cloud
- **API Testing & Workspace:** Postman (`postman/` directory containing collections, environments, and workspace files)
- **Containerization / Deployment Configs:** `Dockerfile`, `fly.toml` (present in repository)

## Project Structure (Key Directories)
- `app/` — Controllers, models, policies, middleware, and application logic
- `database/` — Migrations, seeders, factories, and database configuration
- `routes/` — API and application route definitions
- `postman/` — Postman collections (`CargoTrace API Tests`), environments (`CargoTrace Local`), and workspace resources

## Application & API Links
- **Local Web URL:** [http://127.0.0.1:8000](http://127.0.0.1:8000) (open in browser while `php artisan serve` is running)
- **Live Web URL:** [https://cargotrace-laravel.fly.dev](https://cargotrace-laravel.fly.dev)
- **API Base Prefix (for Postman):** `/api` (e.g., `http://127.0.0.1:8000/api/shipments` or `https://cargotrace-laravel.fly.dev/api/shipments`; `/api` alone is not a browser page)

## Prerequisites & Local Setup
1. **Clone & Install Dependencies:** Ensure PHP, Composer, and required Laravel packages are installed in your local environment.
2. **Environment Configuration:** Configure `.env` with valid database credentials pointing to **TiDB Cloud** and generate the application key if needed.
3. **Run the Development Server:**
   ```bash
   php artisan serve

4. **Configure Postman:**
   - Open Postman and select the **CargoTrace Local** environment.
   - Set `base_url` to your local server URL.
   - Authenticate via login to obtain and store your Sanctum Bearer Token (`{{token}}`).

## Authentication & Request Conventions
- Protected endpoints require an `Authorization: Bearer <token>` header issued through Sanctum.
- API requests expect JSON headers such as `Accept: application/json` (and `Content-Type: application/json` when sending JSON payloads).
- Invalid payloads or disallowed business state transitions return `422 Unprocessable Entity`.
[cite: 9]


## API Endpoints & CRUD Testing Summary

| Method | Endpoint | Purpose | Expected / Verified Behavior |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/login` | User login (`admin@cargotrace.test`) | Issues Sanctum token |
| `GET` | `/api/user` | Authenticated user profile | Returns user data (`200 OK`) |
| `GET` | `/api/shipments` | List shipments | Returns shipment list (`200 OK`) |
| `GET` | `/api/shipments/{id}` | Get shipment details & relations | Returns shipment record (`200 OK`) |
| `POST` | `/api/shipments` | Create shipment | Validates input (`422`), creates (`201 Created`) |
| `PUT` / `PATCH` | `/api/shipments/{id}` | Update shipment / status | Checks status flow (`422`), updates (`200 OK`) |
| `DELETE` | `/api/shipments/{id}` | Delete shipment record | Deletes cleanly (`200 OK`) |