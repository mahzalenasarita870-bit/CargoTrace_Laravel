# CargoTrace_Laravel

Logistics management and shipment tracking platform built with **Laravel**, **Laravel Sanctum** token-based authentication, and **TiDB Cloud** as the database backend. It includes both web operational dashboards (including automated in-app notifications) and a RESTful API, along with **Postman** collections and environments (`CargoTrace API Tests` and `CargoTrace Local`) for endpoint verification and CRUD lifecycle testing.

## Overview
`CargoTrace_Laravel` provides web workflows and authenticated RESTful endpoints to manage shipments, record tracking checkpoints, handle operational exceptions, and trigger automated in-app notifications across shipment, tracking, and exception events.

## Entity Relationship Diagram (ERD)
![Entity Relationship Diagram](docs/erd.png)

## Tech Stack & Infrastructure
- **Backend Framework:** Laravel (local development server via `php artisan serve`)
- **Authentication:** Laravel Sanctum (Bearer Token authentication) & session-based web auth
- **Database:** TiDB Cloud
- **API Testing & Workspace:** Postman (`postman/` directory containing collections, environments, and workspace files)
- **Containerization / Deployment Configs:** `Dockerfile`, `fly.toml` (present in repository)

## Key Features
- **Shipment Management:** Create, view, update, and delete shipments with carrier, origin/destination location, customer, and ETA/delay evaluation (`EtaService`).
- **Tracking Events:** Log and inspect shipment movement checkpoints (`CREATED`, `BOOKED`, `PICKED_UP`, `IN_TRANSIT`, `ARRIVED`, `DELIVERED`, `DELAYED`) and view shipment tracking history.
- **Exception Handling:** Record operational issues (`OPEN`) and mark them as resolved (`RESOLVED`).
- **Automated In-App Notifications:** `NotificationService` automatically creates notifications (`AppNotification`) upon tracking updates, shipment creation/status/delay updates, and exception creation/resolution.

## Project Structure (Key Directories)
- `app/` — Controllers (`ShipmentController`, `TrackingController`, `ExceptionController`, etc.), models (`AppNotification`, `Shipment`, `TrackingEvent`, `ShipmentException`, etc.), services (`NotificationService`, `EtaService`), policies, and middleware
- `database/` — Migrations, seeders (`DatabaseSeeder`), factories, and database configuration
- `docs/` — Project documentation assets (such as `docs/erd.png`)
- `routes/` — API and web route definitions
- `postman/` — Postman collections (`CargoTrace API Tests`), environments (`CargoTrace Local`), and workspace resources

## Application & API Links
- **Local Web URL:** [http://127.0.0.1:8000](http://127.0.0.1:8000) (open in browser while `php artisan serve` is running)
- **Live Web URL:** [https://cargotrace-laravel.fly.dev](https://cargotrace-laravel.fly.dev)
- **API Base Prefix (for Postman):** `/api` (e.g., `http://127.0.0.1:8000/api/shipments` or `https://cargotrace-laravel.fly.dev/api/shipments`; `/api` alone is not a browser page)

## Prerequisites & Local Setup
1. **Clone & Install Dependencies:** Ensure PHP, Composer, and required Laravel packages are installed in your local environment.
2. **Environment Configuration:** Configure `.env` with valid database credentials pointing to **TiDB Cloud** and generate the application key if needed:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. **Run Migrations & Seeder:**
   ```bash
   php artisan migrate --seed
   ```
4. **Run the Development Server:**
   ```bash
   php artisan serve
   ```
5. **Configure Postman:**
   - Open Postman and select the **CargoTrace Local** environment.
   - Set `base_url` to your local server URL (e.g., `http://127.0.0.1:8000`).
   - Authenticate via login to obtain and store your Sanctum Bearer Token (`{{token}}`).

## Authentication & Request Conventions
- Protected API endpoints require an `Authorization: Bearer <token>` header issued through Sanctum.
- API requests expect JSON headers such as `Accept: application/json` (and `Content-Type: application/json` when sending JSON payloads).
- Invalid payloads or disallowed business state transitions return `422 Unprocessable Entity`, while missing records return `404 Not Found`.

## API Endpoints & CRUD Testing Summary

| Method | Endpoint | Purpose | Expected / Verified Behavior |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/login` | User login (`admin@cargotrace.test`) | Issues Sanctum token |
| `GET` | `/api/user` | Authenticated user profile | Returns user data (`200 OK`) |
| `GET` | `/api/shipments` | List shipments | Returns paginated shipment list (`200 OK`) |
| `GET` | `/api/shipments/{id}` | Get shipment details & relations | Returns shipment record (`200 OK`) or `404` if ID not found |
| `POST` | `/api/shipments` | Create shipment | Validates input (`422`), creates (`201 Created`) |
| `PUT` / `PATCH` | `/api/shipments/{id}` | Update shipment / status | Checks status flow (`422`), updates (`200 OK`), or `404` if ID not found |
| `DELETE` | `/api/shipments/{id}` | Delete shipment record | Deletes cleanly (`200 OK`) or `404` if ID not found |