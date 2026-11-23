# System Architecture & Entity Relationship Diagram (ERD)

## 1. Layered Architecture
CargoTrace separates HTTP transport concerns from domain logic:
- **Routes & Middleware (`routes/web.php`, `routes/api.php`, `RoleMiddleware`)**: Handles request routing, authentication (`auth` / `auth:sanctum`), and coarse-grained RBAC.
- **Policies (`ShipmentPolicy`)**: Enforces fine-grained resource ownership (ensuring customers can only access their own shipments).
- **Controllers (`ShipmentController`, `ShipmentApiController`, etc.)**: Validates incoming payloads and delegates operations to services.
- **Service Layer (`ShipmentService`, `TrackingService`, `EtaService`, `ExceptionService`, `ExternalLogisticsService`)**: Encapsulates database transactions, deterministic state transitions, delay evaluations, external HTTP requests, and audit logging.
- **Persistence (`Eloquent Models` + `MySQL 8`)**: Manages relational integrity via foreign keys and indexes.

## 2. Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    USERS ||--o{ SHIPMENTS : "owns (customer_id)"
    CARRIERS ||--o{ SHIPMENTS : "operates (carrier_id)"
    LOCATIONS ||--o{ SHIPMENTS : "origin / destination"
    SHIPMENTS ||--o{ SHIPMENT_ITEMS : "contains"
    SHIPMENTS ||--o{ TRACKING_EVENTS : "records history"
    LOCATIONS ||--o{ TRACKING_EVENTS : "checkpoint"
    USERS ||--o{ TRACKING_EVENTS : "created_by"
    SHIPMENTS ||--o{ SHIPMENT_EXCEPTIONS : "encounters"
    USERS ||--o{ NOTIFICATIONS : "receives"
    USERS ||--o{ AUDIT_LOGS : "performs"