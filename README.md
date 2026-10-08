# 📚 Book System API


## Tech Stack

- PHP 8.2+
- Laravel 12
- MySQL
- Postman 

## Database Tables

| Table | Primary Key |
|---|---|
| `tblBookType` | `BookTypeID` |
| `tblAuthor` | `AuthorID` |
| `tblBook` | `BookID` |
| `tblBookAuthor` | `BookID` + `AuthorID` |

## Getting Started

```bash
# 1. Clone the project
git clone https://github.com/Scheasa/booksys-api.git

# 2. Install dependencies
composer install

# 3. Create the environment file and app key
cp .env.example .env
php artisan key:generate
```

## Configure `.env`

Create an empty MySQL database named `booksys`, then edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booksys
DB_USERNAME=root
DB_PASSWORD=
```

## Run the Project

```bash
php artisan migrate
php artisan serve
```

API base URL: `http://127.0.0.1:8000/api`

## Testing with Postman
### Test order (because of foreign keys)

1. Book Type
2. Author
3. Book
4. Book Author

Delete in the reverse order.

### Book Types: `/book-types`

| Method | URL |
|---|---|
| GET | `/api/book-types` |
| GET | `/api/book-types/1` |
| POST | `/api/book-types` |
| PUT | `/api/book-types/1` |
| DELETE | `/api/book-types/1` |

```json
{
  "BookTypeName": "Science"
}
```

### Authors: `/authors`

| Method | URL |
|---|---|
| GET | `/api/authors` |
| GET | `/api/authors/1` |
| POST | `/api/authors` |
| PUT | `/api/authors/1` |
| DELETE | `/api/authors/1` |

```json
{
  "AuthorName": "Sok Dara",
  "Gender": "Male",
  "DOB": "1985-05-10",
  "Email": "dara@example.com"
}
```

### Books: `/books`

| Method | URL |
|---|---|
| GET | `/api/books` |
| GET | `/api/books/1` |
| POST | `/api/books` |
| PUT | `/api/books/1` |
| DELETE | `/api/books/1` |

```json
{
  "BookTitle": "Intro to Physics",
  "BookTypeID": 1,
  "PublishDate": "2024-01-15",
  "NumOfPages": 300,
  "NumOfCopies": 5,
  "Edition": "1st",
  "Publisher": "BBU Press"
}
```

### Book Authors: `/book-authors`

This table has a composite key, so single-record URLs use two IDs: `/{BookID}/{AuthorID}`.

| Method | URL |
|---|---|
| GET | `/api/book-authors` |
| GET | `/api/book-authors/1/1` |
| POST | `/api/book-authors` |
| PUT | `/api/book-authors/1/1` |
| DELETE | `/api/book-authors/1/1` |

```json
{
  "BookID": 1,
  "AuthorID": 1,
  "AuthorDate": "2024-01-15",
  "Remark": "Main author"
}
```

## Response Format

```json
{
  "success": true,
  "message": "Inserted successfully",
  "data": {}
}
```

| Status Code | Meaning |
|---|---|
| 200 | OK |
| 201 | Created |
| 404 | Not found |
| 422 | Validation failed |
| 500 | Server error |
