# Vellenum API Documentation

This README documents the Vellenum API for local development and testing.
Set the `{{base_url}}` environment variable in your API client (Postman or curl) to your running backend (for example `http://localhost:8000`).

## Quick start

- Import `Vellenum.postman_collection.json` from the project root into Postman to get all pre-built requests.
- Required headers for JSON endpoints:
  - `Accept: application/json`
- For protected endpoints add: `Authorization: Bearer {{token}}` (replace `{{token}}` with the access token returned by login).

## Authentication

- The API uses Laravel Passport tokens. Use `/api/auth/login` (POST) to obtain an access token.
- Login request body (JSON):
  - `email` (string)
  - `password` (string)

Successful login response includes `data.token` which should be used in the `Authorization` header for subsequent protected requests.

## Registration (file uploads)

- Endpoint: `POST /api/auth/register`
- This endpoint accepts `multipart/form-data` to allow file uploads alongside text fields.
- Required common form-data fields:
  - `name`, `email`, `password`, `password_confirmation`, `role` (one of `seller`, `buyer`)
  - Business fields used by sellers: `business_name`, `business_email`, `business_phone`, `business_address`, `country`, `state`, `city`, `zip_code`

- File form keys (the server validator expects these exact keys). Add any combination as needed:
  - `text_identification_file`
  - `proof_of_business_registration_file`
  - `food_safety_certifications_file`
  - `government_issued_id_file`
  - `business_registration_certificate_file`
  - `professional_license_file`
  - `legal_certifications_file`
  - `vehicle_registration_document_file`
  - `vehicle_insurance_document_file`
  - `book_cover_file`
  - `book_file`
  - `product_photo_file`

- Notes on files:
  - Each file is validated with `nullable|file|max:10240` (up to 10 MB).
  - Files are stored on the `public` disk under `files/` and a `File` DB record is created. Seller records reference these `File` rows via `*_file_id` columns.

### Example: register via curl (multipart)

Replace `{{base_url}}` with your host and attach local files.

```bash
curl -X POST "{{base_url}}/api/auth/register" \
  -H "Accept: application/json" \
  -F "name=John Seller" \
  -F "email=john.seller@example.com" \
  -F "password=password123" \
  -F "password_confirmation=password123" \
  -F "role=seller" \
  -F "business_name=Johns Goods" \
  -F "business_email=business@example.com" \
  -F "business_phone=+15557654321" \
  -F "business_address=123 Market St" \
  -F "country=USA" \
  -F "state=CA" \
  -F "city=San Francisco" \
  -F "zip_code=94105" \
  -F "text_identification_file=@/path/to/id.jpg" \
  -F "product_photo_file=@/path/to/photo.jpg"
```

(Use Postman form-data UI when testing interactively; choose the `file` type for file keys.)

## Files endpoints

- Upload single file: `POST /api/files/upload` (multipart, `file` key)
- Bulk upload: `POST /api/files/bulk-upload` (multipart, `files[]` or repeated `files` keys)
- List files: `GET /api/files` (query params: `category`, `uploaded_by`, `public_only`, `search`)
- Download: `GET /api/files/{id}/download`

Protected file endpoints require `Authorization: Bearer {{token}}`.

## Important implementation notes

- `app/Http/Controllers/Api/AuthController.php` accepts the file keys listed above and maps them to `File` records. Ensure your client form keys match exactly.
- `Vellenum.postman_collection.json` in the project root contains prebuilt register templates already converted to `form-data` with the file keys.

## Troubleshooting

- If you see "Unable to determine authentication provider for this model from configuration" when using Passport, ensure `config/auth.php` includes an `api` guard configured for Passport and that Laravel caches are cleared:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

- For file permission issues, ensure `storage` and `public/storage` are writable and the public disk is linked:

```bash
php artisan storage:link
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Postman

- Import `Vellenum.postman_collection.json` to test endpoints. The collection includes the `Accept: application/json` header per-request; you may move it to the collection-level header if preferred.

## Contact / next steps

If you want, I can:
- Move `Accept: application/json` to collection-level in the Postman file.
- Add example local filenames to the collection form-data `src` entries (note: Postman may require you to reattach files locally).
- Provide a small integration script to programmatically register a test seller and verify `files` rows are created.

---
Generated: API-focused README for Vellenum