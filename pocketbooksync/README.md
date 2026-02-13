# PocketBook Sync (Nextcloud App)

This app syncs PocketBook Cloud highlights/notes into Nextcloud markdown files:

- One markdown file per book.
- File name format: `Book Title - Author.md`.
- Personal settings page for credentials, target folder, sync interval.
- Connection test + last sync status.
- Background job that checks each user's configured interval.

## Notes on PocketBook API

The app currently expects these endpoints:

- `POST /api/v1/auth/login` with `{ "email": "...", "password": "..." }` and response `{ "token": "..." }`
- `GET /api/v1/library/books?includeAnnotations=true` with Bearer token and response `{ "books": [...] }`

If your PocketBook Cloud account uses different endpoints/field names,
adapt `lib/Service/PocketBookClient.php` accordingly.
