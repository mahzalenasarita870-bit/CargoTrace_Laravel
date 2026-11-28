# CargoTrace_Laravel

Logistics management and shipment tracking platform built with **Laravel**, **Laravel Sanctum** token-based authentication, and **TiDB Cloud** as the database backend. It includes both web operational dashboards (including automated in-app notifications) and a RESTful API, along with **Postman** collections and environments (`CargoTrace API Tests` and `CargoTrace Local`) for endpoint verification and CRUD lifecycle testing.

## Overview
`CargoTrace_Laravel` provides web workflows and authenticated RESTful endpoints to manage shipments, record tracking checkpoints, handle operational exceptions, and trigger automated in-app notifications across shipment, tracking, and exception events.

## Entity Relationship Diagram (ERD)

Sistem **CargoTrace** menggunakan **9 tabel** relasional dengan kardinalitas **`1:N`** (*one-to-many*) yang berpusat pada entitas `Shipments`.

(![CargoTrace ERD](ERD-cargotrace.png))


### Relasi & Kardinalitas (`1:N`)

* **`Users` (1) ─── (N) `Shipments`** via `Shipments.Customer_id`
* **`Users` (1) ─── (N) `Tracking_events`** via `Tracking_events.Created_by`
* **`Users` (1) ─── (N) `Shipment_exceptions`** via `Shipment_exceptions.Resolved_by`
* **`Users` (1) ─── (N) `Notifications`** via `Notifications.User_id`
* **`Users` (1) ─── (N) `Audit_logs`** via `Audit_logs.User_id`
* **`Carriers` (1) ─── (N) `Shipments`** via `Shipments.Carrier_id`
* **`Locations` (1) ─── (N) `Shipments`** via `Shipments.Origin_location_id`
* **`Locations` (1) ─── (N) `Shipments`** via `Shipments.Destination_location_id`
* **`Locations` (1) ─── (N) `Tracking_events`** via `Tracking_events.Location_id`
* **`Shipments` (1) ─── (N) `Shipment_items`** via `Shipment_items.Shipment_id`
* **`Shipments` (1) ─── (N) `Tracking_events`** via `Tracking_events.Shipment_id`
* **`Shipments` (1) ─── (N) `Shipment_exceptions`** via `Shipment_exceptions.Shipment_id`
* **`Shipments` (1) ─── (N) `Notifications`** via `Notifications.Shipment_id`

*(Catatan: `Audit_logs` menggunakan `Auditable_type` dan `Auditable_id` secara polimorfik selain relasi `User_id`.)*

## Data Dictionary

### 1. `Users`
Menyimpan data pengguna sistem CargoTrace (seperti pelanggan, operator, atau admin).

| Kolom | Tipe Data | Constraint / Default | Keterangan |
| :--- | :--- | :--- | :--- |
| `Id` | `BIGINT UNSIGNED` | `PK`, `AUTO_INCREMENT`, `NOT NULL` | Identifier unik pengguna |
| `Name` | `VARCHAR(255)` | `NOT NULL` | Nama lengkap pengguna |
| `Email` | `VARCHAR(255)` | `UNIQUE`, `NOT NULL` | Alamat email unik untuk login/notifikasi |
| `Email_verified_at` | `TIMESTAMP` | `NULLABLE` | Waktu verifikasi email |
| `Password` | `VARCHAR(255)` | `NOT NULL` | Hash kata sandi pengguna |
| `Remember_token` | `VARCHAR(100)` | `NULLABLE` | Token sesi *remember me* |
| `Role` | `VARCHAR(50)` | `DEFAULT 'CUSTOMER'`, `NOT NULL` | Peran pengguna di sistem |
| `Created_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembuatan data |
| `Updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembaruan terakhir data |

### 2. `Carriers`
Menyimpan data perusahaan ekspedisi / penyedia jasa pengiriman (*carrier*).

| Kolom | Tipe Data | Constraint / Default | Keterangan |
| :--- | :--- | :--- | :--- |
| `Id` | `BIGINT UNSIGNED` | `PK`, `AUTO_INCREMENT`, `NOT NULL` | Identifier unik *carrier* |
| `Name` | `VARCHAR(255)` | `NOT NULL` | Nama perusahaan *carrier* |
| `Code` | `VARCHAR(50)` | `UNIQUE`, `NOT NULL` | Kode unik *carrier* |
| `Phone` | `VARCHAR(50)` | `NULLABLE` | Nomor telepon kontak *carrier* |
| `Email` | `VARCHAR(255)` | `NULLABLE` | Alamat email kontak *carrier* |
| `Created_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembuatan data |
| `Updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembaruan terakhir data |

### 3. `Locations`
Menyimpan data titik lokasi (gudang, pelabuhan, hub, atau alamat asal/tujuan).

| Kolom | Tipe Data | Constraint / Default | Keterangan |
| :--- | :--- | :--- | :--- |
| `Id` | `BIGINT UNSIGNED` | `PK`, `AUTO_INCREMENT`, `NOT NULL` | Identifier unik lokasi |
| `Name` | `VARCHAR(255)` | `NOT NULL` | Nama lokasi / fasilitas |
| `City` | `VARCHAR(100)` | `NOT NULL` | Nama kota |
| `Country` | `VARCHAR(100)` | `NOT NULL` | Nama negara |
| `Latitude` | `DECIMAL(10,7)` | `NULLABLE` | Koordinat lintang lokasi |
| `Longitude` | `DECIMAL(10,7)` | `NULLABLE` | Koordinat bujur lokasi |
| `Created_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembuatan data |
| `Updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembaruan terakhir data |

### 4. `Shipments`
Tabel utama transaksi pengiriman kargo yang menghubungkan pelanggan, *carrier*, serta lokasi asal dan tujuan.

| Kolom | Tipe Data | Constraint / Default | Keterangan |
| :--- | :--- | :--- | :--- |
| `Id` | `BIGINT UNSIGNED` | `PK`, `AUTO_INCREMENT`, `NOT NULL` | Identifier unik pengiriman |
| `Customer_id` | `BIGINT UNSIGNED` | `FK -> Users.Id`, `NOT NULL` | Pemilik/pelanggan pengiriman |
| `Carrier_id` | `BIGINT UNSIGNED` | `FK -> Carriers.Id`, `NOT NULL` | *Carrier* yang menangani pengiriman |
| `Origin_location_id` | `BIGINT UNSIGNED` | `FK -> Locations.Id`, `NOT NULL` | Lokasi asal pengiriman |
| `Destination_location_id` | `BIGINT UNSIGNED` | `FK -> Locations.Id`, `NOT NULL` | Lokasi tujuan pengiriman |
| `Shipment_number` | `VARCHAR(100)` | `UNIQUE`, `NOT NULL` | Nomor resi / kode unik pengiriman |
| `Cargo_type` | `VARCHAR(100)` | `NOT NULL` | Jenis kargo/barang |
| `Weight` | `DECIMAL(10,2)` | `NULLABLE` | Total berat kargo |
| `Volume` | `DECIMAL(10,3)` | `NULLABLE` | Total volume kargo |
| `Expected_departure` | `DATETIME` | `NULLABLE` | Jadwal keberangkatan yang diharapkan |
| `Expected_arrival` | `DATETIME` | `NULLABLE` | Jadwal kedatangan yang diharapkan |
| `Estimated_arrival` | `DATETIME` | `NULLABLE` | Estimasi waktu tiba terkini (ETA) |
| `Actual_arrival` | `DATETIME` | `NULLABLE` | Waktu tiba aktual di tujuan |
| `Current_status` | `VARCHAR(50)` | `DEFAULT 'CREATED'`, `NOT NULL` | Status pengiriman saat ini |
| `Is_delayed` | `BOOLEAN` | `DEFAULT FALSE`, `NOT NULL` | Penanda apakah pengiriman mengalami keterlambatan |
| `Delay_hours` | `INT` | `DEFAULT 0`, `NOT NULL` | Durasi keterlambatan dalam jam |
| `Delay_severity` | `VARCHAR(50)` | `NULLABLE` | Tingkat keparahan keterlambatan |
| `Delay_reason` | `TEXT` | `NULLABLE` | Alasan atau catatan keterlambatan |
| `Created_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembuatan data |
| `Updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembaruan terakhir data |

### 5. `Shipment_items`
Menyimpan rincian item/barang yang dimuat dalam suatu pengiriman (`Shipments`).

| Kolom | Tipe Data | Constraint / Default | Keterangan |
| :--- | :--- | :--- | :--- |
| `Id` | `BIGINT UNSIGNED` | `PK`, `AUTO_INCREMENT`, `NOT NULL` | Identifier unik item pengiriman |
| `Shipment_id` | `BIGINT UNSIGNED` | `FK -> Shipments.Id`, `NOT NULL` | Referensi ke pengiriman induk |
| `Item_name` | `VARCHAR(255)` | `NOT NULL` | Nama barang/item |
| `Sku` | `VARCHAR(100)` | `NULLABLE` | Kode SKU barang |
| `Quantity` | `INT` | `DEFAULT 1`, `NOT NULL` | Jumlah unit item |
| `Weight_kg` | `DECIMAL(10,2)` | `DEFAULT 0`, `NOT NULL` | Berat item dalam kilogram (kg) |
| `Volume_cbm` | `DECIMAL(10,3)` | `NULLABLE` | Volume item dalam meter kubik (CBM) |
| `Notes` | `TEXT` | `NULLABLE` | Catatan tambahan item |
| `Created_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembuatan data |
| `Updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembaruan terakhir data |

### 6. `Tracking_events`
Mencatat riwayat pergerakan dan status kejadian (*event*) selama pengiriman berlangsung.

| Kolom | Tipe Data | Constraint / Default | Keterangan |
| :--- | :--- | :--- | :--- |
| `Id` | `BIGINT UNSIGNED` | `PK`, `AUTO_INCREMENT`, `NOT NULL` | Identifier unik *tracking event* |
| `Shipment_id` | `BIGINT UNSIGNED` | `FK -> Shipments.Id`, `NOT NULL` | Referensi pengiriman terkait |
| `Event_type` | `VARCHAR(100)` | `NOT NULL` | Jenis *event* pelacakan |
| `Event_time` | `DATETIME` | `NOT NULL` | Waktu terjadinya *event* |
| `Location_id` | `BIGINT UNSIGNED` | `FK -> Locations.Id`, `NULLABLE` | Lokasi terjadinya *event* |
| `Latitude` | `DECIMAL(10,7)` | `NULLABLE` | Koordinat lintang saat *event* |
| `Longitude` | `DECIMAL(10,7)` | `NULLABLE` | Koordinat bujur saat *event* |
| `Description` | `TEXT` | `NULLABLE` | Uraian/keterangan *event* |
| `Created_by` | `BIGINT UNSIGNED` | `FK -> Users.Id`, `NULLABLE` | Pengguna yang mencatat *event* |
| `Created_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembuatan data |
| `Updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembaruan terakhir data |

### 7. `Shipment_exceptions`
Mencatat kendala atau pengecualian (*exception*) yang terjadi pada pengiriman beserta status penanganannya.

| Kolom | Tipe Data | Constraint / Default | Keterangan |
| :--- | :--- | :--- | :--- |
| `Id` | `BIGINT UNSIGNED` | `PK`, `AUTO_INCREMENT`, `NOT NULL` | Identifier unik *exception* |
| `Shipment_id` | `BIGINT UNSIGNED` | `FK -> Shipments.Id`, `NOT NULL` | Referensi pengiriman yang bermasalah |
| `Exception_type` | `VARCHAR(100)` | `NOT NULL` | Jenis kendala/*exception* |
| `Severity` | `VARCHAR(50)` | `DEFAULT 'LOW'`, `NOT NULL` | Tingkat keparahan kendala |
| `Status` | `VARCHAR(50)` | `DEFAULT 'OPEN'`, `NOT NULL` | Status penanganan kendala |
| `Description` | `TEXT` | `NOT NULL` | Deskripsi detail kendala |
| `Detected_at` | `DATETIME` | `NOT NULL` | Waktu kendala terdeteksi |
| `Resolved_at` | `DATETIME` | `NULLABLE` | Waktu kendala selesai ditangani |
| `Resolved_by` | `BIGINT UNSIGNED` | `FK -> Users.Id`, `NULLABLE` | Pengguna yang menyelesaikan kendala |
| `Created_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembuatan data |
| `Updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembaruan terakhir data |

### 8. `Notifications`
Menyimpan notifikasi sistem yang dikirimkan ke pengguna terkait aktivitas atau status pengiriman.

| Kolom | Tipe Data | Constraint / Default | Keterangan |
| :--- | :--- | :--- | :--- |
| `Id` | `BIGINT UNSIGNED` | `PK`, `AUTO_INCREMENT`, `NOT NULL` | Identifier unik notifikasi |
| `User_id` | `BIGINT UNSIGNED` | `FK -> Users.Id`, `NOT NULL` | Penerima notifikasi |
| `Shipment_id` | `BIGINT UNSIGNED` | `FK -> Shipments.Id`, `NULLABLE` | Pengiriman terkait notifikasi |
| `Type` | `VARCHAR(100)` | `NOT NULL` | Jenis/kategori notifikasi |
| `Title` | `VARCHAR(255)` | `NOT NULL` | Judul notifikasi |
| `Message` | `TEXT` | `NOT NULL` | Isi pesan notifikasi |
| `Read_at` | `TIMESTAMP` | `NULLABLE` | Waktu notifikasi dibaca pengguna |
| `Created_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembuatan data |
| `Updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembaruan terakhir data |

### 9. `Audit_logs`
Mencatat jejak audit perubahan data (*old values* dan *new values*) serta aktivitas pengguna di sistem.

| Kolom | Tipe Data | Constraint / Default | Keterangan |
| :--- | :--- | :--- | :--- |
| `Id` | `BIGINT UNSIGNED` | `PK`, `AUTO_INCREMENT`, `NOT NULL` | Identifier unik *audit log* |
| `User_id` | `BIGINT UNSIGNED` | `FK -> Users.Id`, `NULLABLE` | Pengguna yang melakukan aksi |
| `Action` | `VARCHAR(100)` | `NOT NULL` | Jenis aksi (misalnya `created`, `updated`, `deleted`) |
| `Auditable_type` | `VARCHAR(255)` | `NOT NULL` | Nama model/entitas target (relasi polimorfik) |
| `Auditable_id` | `BIGINT UNSIGNED` | `NOT NULL` | ID record target pada entitas terkait |
| `Old_values` | `JSON` | `NULLABLE` | Nilai data sebelum perubahan |
| `New_values` | `JSON` | `NULLABLE` | Nilai data sesudah perubahan |
| `Ip_address` | `VARCHAR(45)` | `NULLABLE` | Alamat IP asal permintaan |
| `Created_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembuatan log |
| `Updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu pembaruan log |

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