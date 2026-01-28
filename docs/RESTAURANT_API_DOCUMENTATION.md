# Restaurant API Documentation

## Table of Contents

1. [Overview](#overview)
2. [Base URL](#base-url)
3. [Authentication](#authentication)
4. [Data Model](#data-model)
5. [API Endpoints](#api-endpoints)
    - [Public API](#public-api)
    - [Admin API (Web Routes)](#admin-api-web-routes)
6. [Error Handling](#error-handling)
7. [Examples](#examples)

---

## Overview

The Restaurant API provides endpoints to manage and retrieve restaurant information for the FIGO Holidays application. It supports both public API endpoints for mobile/web applications and authenticated admin endpoints for CRUD operations.

---

## Base URL

- **Public API**: `https://your-domain.com/api/v1`
- **Admin Web Routes**: `https://your-domain.com` (requires authentication)

---

## Authentication

### Public API Endpoints

- **No authentication required** for read operations

### Admin Web Routes

- **Authentication required** via Laravel session/Sanctum
- User must be logged in with appropriate permissions
- CSRF token required for POST, PUT, DELETE requests

---

## Data Model

### Restaurant Object

| Field         | Type        | Required | Validation         | Description                                          |
| ------------- | ----------- | -------- | ------------------ | ---------------------------------------------------- |
| `id`          | integer     | Auto     | -                  | Unique identifier                                    |
| `name`        | string      | Yes      | max:255            | Restaurant name                                      |
| `type`        | string      | Yes      | max:255            | Restaurant type/cuisine (e.g., "Italian", "Chinese") |
| `rating`      | integer     | Yes      | between:1,5        | Rating from 1 to 5 stars                             |
| `map_url`     | string      | No       | url                | Google Maps or location URL                          |
| `image`       | string/file | No       | image, max:5120KB  | Restaurant image path                                |
| `description` | text        | No       | -                  | Detailed description                                 |
| `status`      | string      | Yes      | in:active,inactive | Restaurant status                                    |
| `created_at`  | timestamp   | Auto     | -                  | Creation timestamp                                   |
| `updated_at`  | timestamp   | Auto     | -                  | Last update timestamp                                |

### Example Restaurant Object

```json
{
    "id": 1,
    "name": "The Golden Spoon",
    "type": "Fine Dining",
    "rating": 5,
    "map_url": "https://maps.google.com/?q=The+Golden+Spoon",
    "image": "https://your-domain.com/storage/restaurants/restaurant-image.jpg",
    "description": "An exquisite fine dining experience with international cuisine",
    "status": "active",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-20T14:45:00.000000Z"
}
```

---

## API Endpoints

### Public API

#### 1. Get All Restaurants

Retrieve a list of all restaurants with full image URLs.

**Endpoint**: `GET /api/v1/restaurants`

**Headers**:

```
Accept: application/json
```

**Query Parameters**:

| Parameter | Type   | Required | Description                                        |
| --------- | ------ | -------- | -------------------------------------------------- |
| `type`    | string | No       | Filter restaurants by cuisine type (partial match) |

**Response**: `200 OK`

**Example 1: Get All Restaurants**

```bash
GET /api/v1/restaurants
```

```json
[
    {
        "id": 1,
        "name": "The Golden Spoon",
        "type": "Fine Dining",
        "rating": 5,
        "map_url": "https://maps.google.com/?q=The+Golden+Spoon",
        "image": "https://your-domain.com/storage/restaurants/restaurant-1.jpg",
        "description": "An exquisite fine dining experience",
        "status": "active",
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-20T14:45:00.000000Z"
    },
    {
        "id": 2,
        "name": "Spice Garden",
        "type": "Asian Fusion",
        "rating": 4,
        "map_url": "https://maps.google.com/?q=Spice+Garden",
        "image": "https://your-domain.com/storage/restaurants/restaurant-2.jpg",
        "description": "Authentic Asian flavors with a modern twist",
        "status": "active",
        "created_at": "2024-01-16T11:00:00.000000Z",
        "updated_at": "2024-01-21T09:30:00.000000Z"
    }
]
```

**Example 2: Filter by Cuisine Type**

```bash
GET /api/v1/restaurants?type=italian
```

```json
[
    {
        "id": 3,
        "name": "Bella Italia",
        "type": "Italian",
        "rating": 5,
        "map_url": "https://maps.google.com/?q=Bella+Italia",
        "image": "https://your-domain.com/storage/restaurants/restaurant-3.jpg",
        "description": "Authentic Italian cuisine in a cozy atmosphere",
        "status": "active",
        "created_at": "2024-01-17T12:00:00.000000Z",
        "updated_at": "2024-01-22T10:00:00.000000Z"
    },
    {
        "id": 4,
        "name": "Pasta Paradise",
        "type": "Italian Bistro",
        "rating": 4,
        "map_url": "https://maps.google.com/?q=Pasta+Paradise",
        "image": "https://your-domain.com/storage/restaurants/restaurant-4.jpg",
        "description": "Fresh pasta made daily",
        "status": "active",
        "created_at": "2024-01-18T13:30:00.000000Z",
        "updated_at": "2024-01-23T11:15:00.000000Z"
    }
]
```

**Implementation Details**:

- Returns all restaurants ordered by latest first
- Image URLs are automatically converted to full URLs
- No pagination applied
- Filter by `type` parameter uses partial matching (LIKE search)
- Type filter is case-insensitive

---

### Admin API (Web Routes)

All admin endpoints require authentication via `auth` middleware.

#### 2. List Restaurants (Admin View)

Display paginated list of restaurants with search functionality.

**Endpoint**: `GET /restaurants`

**Authentication**: Required

**Query Parameters**:

| Parameter | Type    | Required | Description              |
| --------- | ------- | -------- | ------------------------ |
| `search`  | string  | No       | Search by name or type   |
| `page`    | integer | No       | Page number (default: 1) |

**Response**: Returns Blade view with paginated restaurants (10 per page)

**Example Request**:

```
GET /restaurants?search=italian&page=1
```

---

#### 3. Show Create Form

Display form to create a new restaurant.

**Endpoint**: `GET /restaurants/create`

**Authentication**: Required

**Response**: Returns Blade view with create form

---

#### 4. Create Restaurant

Store a new restaurant in the database.

**Endpoint**: `POST /restaurants`

**Authentication**: Required

**Headers**:

```
Content-Type: multipart/form-data
X-CSRF-TOKEN: {csrf_token}
```

**Request Body**:

| Field         | Type    | Required | Validation         |
| ------------- | ------- | -------- | ------------------ |
| `name`        | string  | Yes      | max:255            |
| `type`        | string  | Yes      | max:255            |
| `rating`      | integer | Yes      | between:1,5        |
| `map_url`     | string  | No       | valid URL          |
| `image`       | file    | No       | image, max:5MB     |
| `description` | text    | No       | -                  |
| `status`      | string  | Yes      | active or inactive |

**Example Request** (Form Data):

```
name: The Golden Spoon
type: Fine Dining
rating: 5
map_url: https://maps.google.com/?q=The+Golden+Spoon
image: [file upload]
description: An exquisite fine dining experience
status: active
```

**Success Response**: `302 Redirect`

```
Redirects to: /restaurants
Flash Message: "Restaurant added successfully."
```

**Error Response**: `302 Redirect Back`

```
Flash Message: "Error: {error_message}"
Returns with input data
```

**Validation Errors**: `422 Unprocessable Entity`

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": ["The name field is required."],
        "rating": ["The rating must be between 1 and 5."]
    }
}
```

**Implementation Notes**:

- Uses database transaction for data integrity
- Image stored in `storage/app/public/restaurants/` directory
- Automatic rollback on error

---

#### 5. Show Edit Form

Display form to edit an existing restaurant.

**Endpoint**: `GET /restaurants/{id}/edit`

**Authentication**: Required

**URL Parameters**:

| Parameter | Type    | Required | Description   |
| --------- | ------- | -------- | ------------- |
| `id`      | integer | Yes      | Restaurant ID |

**Response**: Returns Blade view with edit form and restaurant data

**Error Response**: `404 Not Found` if restaurant doesn't exist

---

#### 6. Update Restaurant

Update an existing restaurant.

**Endpoint**: `PUT /restaurants/{id}` or `POST /restaurants/{id}` with `_method=PUT`

**Authentication**: Required

**Headers**:

```
Content-Type: multipart/form-data
X-CSRF-TOKEN: {csrf_token}
```

**URL Parameters**:

| Parameter | Type    | Required | Description   |
| --------- | ------- | -------- | ------------- |
| `id`      | integer | Yes      | Restaurant ID |

**Request Body**: Same as Create Restaurant

**Example Request** (Form Data):

```
_method: PUT
name: The Golden Spoon Updated
type: Fine Dining
rating: 5
map_url: https://maps.google.com/?q=The+Golden+Spoon
image: [optional new file upload]
description: Updated description
status: active
```

**Success Response**: `302 Redirect`

```
Redirects to: /restaurants
Flash Message: "Restaurant updated successfully."
```

**Error Response**: `302 Redirect Back`

```
Flash Message: "Update Failed: {error_message}"
```

**Implementation Notes**:

- Uses database transaction
- If new image uploaded, old image is deleted from storage
- Automatic rollback on error
- Old image only deleted if new image successfully uploaded

---

#### 7. Delete Restaurant

Delete a restaurant from the database.

**Endpoint**: `DELETE /restaurants/{id}` or `POST /restaurants/{id}` with `_method=DELETE`

**Authentication**: Required

**Headers**:

```
X-CSRF-TOKEN: {csrf_token}
```

**URL Parameters**:

| Parameter | Type    | Required | Description   |
| --------- | ------- | -------- | ------------- |
| `id`      | integer | Yes      | Restaurant ID |

**Success Response**: `302 Redirect`

```
Redirects to: /restaurants
Flash Message: "Restaurant deleted successfully."
```

**Error Response**: `404 Not Found` if restaurant doesn't exist

**Implementation Notes**:

- Deletes associated image from storage if exists
- Permanent deletion (soft delete not implemented)

---

## Error Handling

### HTTP Status Codes

| Code  | Description                           |
| ----- | ------------------------------------- |
| `200` | Success                               |
| `302` | Redirect (after successful operation) |
| `404` | Restaurant not found                  |
| `422` | Validation error                      |
| `500` | Server error                          |

### Error Response Format

**Validation Errors**:

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "field_name": ["Error message 1", "Error message 2"]
    }
}
```

**Server Errors**:

```
Flash Message: "Error: {detailed_error_message}"
```

---

## Examples

### Example 1: Fetch All Restaurants (Public API)

**Request**:

```bash
curl -X GET "https://your-domain.com/api/v1/restaurants" \
  -H "Accept: application/json"
```

**Response**:

```json
[
    {
        "id": 1,
        "name": "The Golden Spoon",
        "type": "Fine Dining",
        "rating": 5,
        "map_url": "https://maps.google.com/?q=The+Golden+Spoon",
        "image": "https://your-domain.com/storage/restaurants/restaurant-1.jpg",
        "description": "An exquisite fine dining experience",
        "status": "active",
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-20T14:45:00.000000Z"
    }
]
```

---

### Example 2: Create Restaurant (Admin)

**Request**:

```bash
curl -X POST "https://your-domain.com/restaurants" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -H "Cookie: laravel_session=your-session-cookie" \
  -F "name=Ocean View Restaurant" \
  -F "type=Seafood" \
  -F "rating=4" \
  -F "map_url=https://maps.google.com/?q=Ocean+View" \
  -F "image=@/path/to/image.jpg" \
  -F "description=Fresh seafood with ocean views" \
  -F "status=active"
```

**Response**: Redirects to `/restaurants` with success message

---

### Example 3: Update Restaurant (Admin)

**Request**:

```bash
curl -X POST "https://your-domain.com/restaurants/1" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -H "Cookie: laravel_session=your-session-cookie" \
  -F "_method=PUT" \
  -F "name=Ocean View Restaurant - Updated" \
  -F "type=Seafood & Grill" \
  -F "rating=5" \
  -F "map_url=https://maps.google.com/?q=Ocean+View" \
  -F "description=Fresh seafood and grilled specialties with ocean views" \
  -F "status=active"
```

**Response**: Redirects to `/restaurants` with success message

---

### Example 4: Delete Restaurant (Admin)

**Request**:

```bash
curl -X POST "https://your-domain.com/restaurants/1" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -H "Cookie: laravel_session=your-session-cookie" \
  -F "_method=DELETE"
```

**Response**: Redirects to `/restaurants` with success message

---

### Example 5: Search Restaurants (Admin)

**Request**:

```bash
curl -X GET "https://your-domain.com/restaurants?search=seafood" \
  -H "Cookie: laravel_session=your-session-cookie"
```

**Response**: Returns HTML view with filtered results

---

## JavaScript/Axios Examples

### Fetch Restaurants (Public API)

```javascript
// Using Axios
axios
    .get("https://your-domain.com/api/v1/restaurants")
    .then((response) => {
        console.log("Restaurants:", response.data);
        response.data.forEach((restaurant) => {
            console.log(
                `${restaurant.name} - ${restaurant.type} - ${restaurant.rating} stars`,
            );
        });
    })
    .catch((error) => {
        console.error("Error fetching restaurants:", error);
    });

// Using Fetch API
fetch("https://your-domain.com/api/v1/restaurants")
    .then((response) => response.json())
    .then((data) => {
        console.log("Restaurants:", data);
    })
    .catch((error) => {
        console.error("Error:", error);
    });
```

### Filter Restaurants by Cuisine Type

```javascript
// Filter by cuisine type (e.g., Italian, Asian, Seafood)
axios
    .get("https://your-domain.com/api/v1/restaurants", {
        params: {
            type: "italian",
        },
    })
    .then((response) => {
        console.log("Italian Restaurants:", response.data);
        response.data.forEach((restaurant) => {
            console.log(`${restaurant.name} - ${restaurant.type}`);
        });
    })
    .catch((error) => {
        console.error("Error:", error);
    });

// Dynamic filter with user input
function filterRestaurantsByType(cuisineType) {
    const params = cuisineType ? { type: cuisineType } : {};

    axios
        .get("https://your-domain.com/api/v1/restaurants", { params })
        .then((response) => {
            console.log(
                `Restaurants (${cuisineType || "All"}):`,
                response.data,
            );
            displayRestaurants(response.data);
        })
        .catch((error) => {
            console.error("Error fetching restaurants:", error);
        });
}

// Usage
filterRestaurantsByType("seafood"); // Get seafood restaurants
filterRestaurantsByType(""); // Get all restaurants
```

### Restaurant Filter Component (React Example)

````javascript
import { useState, useEffect } from 'react';
import axios from 'axios';

function RestaurantList() {
  const [restaurants, setRestaurants] = useState([]);
  const [cuisineFilter, setCuisineFilter] = useState('');
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    setLoading(true);
    const params = cuisineFilter ? { type: cuisineFilter } : {};

    axios.get('https://your-domain.com/api/v1/restaurants', { params })
      .then(response => {
        setRestaurants(response.data);
        setLoading(false);
      })
      .catch(error => {
        console.error('Error fetching restaurants:', error);
        setLoading(false);
      });
  }, [cuisineFilter]);

  return (
    <div>
      <input
        type="text"
        placeholder="Filter by cuisine type (e.g., Italian, Asian)"
        value={cuisineFilter}
        onChange={(e) => setCuisineFilter(e.target.value)}
      />

      {loading ? (
        <p>Loading...</p>
      ) : (
        <ul>
          {restaurants.map(restaurant => (
            <li key={restaurant.id}>
              <h3>{restaurant.name}</h3>
              <p>Type: {restaurant.type}</p>
              <p>Rating: {restaurant.rating} stars</p>
              <img src={restaurant.image} alt={restaurant.name} />
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}


### Create Restaurant (Admin - with CSRF)

```javascript
// Get CSRF token from meta tag
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Create FormData
const formData = new FormData();
formData.append("name", "New Restaurant");
formData.append("type", "Italian");
formData.append("rating", 5);
formData.append("map_url", "https://maps.google.com/?q=New+Restaurant");
formData.append("description", "Authentic Italian cuisine");
formData.append("status", "active");

// If you have an image file input
const imageInput = document.querySelector("#image");
if (imageInput.files[0]) {
    formData.append("image", imageInput.files[0]);
}

// Send request
axios
    .post("/restaurants", formData, {
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Content-Type": "multipart/form-data",
        },
    })
    .then((response) => {
        console.log("Restaurant created successfully");
        window.location.href = "/restaurants";
    })
    .catch((error) => {
        console.error("Error creating restaurant:", error.response.data);
    });
````

---

## Image Handling

### Image Upload

- **Accepted formats**: JPG, JPEG, PNG, GIF, SVG, WEBP
- **Maximum size**: 5MB (5120KB)
- **Storage location**: `storage/app/public/restaurants/`
- **Public URL**: `https://your-domain.com/storage/restaurants/{filename}`

### Image URL Conversion

The API automatically converts relative storage paths to full URLs:

- **Stored in DB**: `restaurants/abc123.jpg`
- **Returned by API**: `https://your-domain.com/storage/restaurants/abc123.jpg`

### Image Deletion

- When updating a restaurant with a new image, the old image is automatically deleted
- When deleting a restaurant, the associated image is automatically deleted

---

## Best Practices

1. **Always validate input** on the client side before sending requests
2. **Handle image uploads** properly with appropriate file size checks
3. **Use transactions** when performing multiple database operations
4. **Implement proper error handling** for network failures
5. **Cache restaurant data** on the client side when appropriate
6. **Use pagination** for large datasets (admin interface already implements this)
7. **Sanitize user input** to prevent XSS attacks
8. **Optimize images** before uploading to reduce storage and bandwidth

---

## Rate Limiting

Currently, no rate limiting is implemented. Consider implementing rate limiting for production:

```php
// In routes/api.php
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/restaurants', [ApiController::class, 'restaurants']);
});
```

---

## Changelog

### Version 1.0.1 (Current)

- Added `type` query parameter filter to public API endpoint
- Restaurants can now be filtered by cuisine type (partial match)
- Enhanced JavaScript examples with filter demonstrations
- Added React component example for dynamic filtering

### Version 1.0.0

- Initial API implementation
- CRUD operations for restaurants
- Public API endpoint for listing restaurants
- Image upload and management
- Search functionality
- Pagination support

---

## Support

For issues or questions, please contact the development team or create an issue in the project repository.

---

**Last Updated**: January 2026  
**API Version**: 1.0.1  
**Laravel Version**: 10.x+
