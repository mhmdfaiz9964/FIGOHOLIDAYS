# Destination API Documentation

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

The Destination API provides endpoints to manage and retrieve destination information for the FIGO Holidays application. Destinations are associated with provinces and include attractions, descriptions, and images. The API supports both public endpoints for mobile/web applications and authenticated admin endpoints for CRUD operations.

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

### Destination Object

| Field         | Type        | Required | Validation          | Description                      |
| ------------- | ----------- | -------- | ------------------- | -------------------------------- |
| `id`          | integer     | Auto     | -                   | Unique identifier                |
| `name`        | string      | Yes      | max:255             | Destination name                 |
| `province_id` | integer     | Yes      | exists:provinces,id | Foreign key to provinces table   |
| `image`       | string/file | No       | image, max:5120KB   | Destination image path           |
| `attractions` | array       | No       | -                   | List of attractions (JSON array) |
| `description` | text        | No       | -                   | Detailed description             |
| `label`       | string      | No       | max:255             | Label/tag for the destination    |
| `status`      | string      | Yes      | in:active,inactive  | Destination status               |
| `created_at`  | timestamp   | Auto     | -                   | Creation timestamp               |
| `updated_at`  | timestamp   | Auto     | -                   | Last update timestamp            |

### Province Object (Relationship)

| Field        | Type      | Description                |
| ------------ | --------- | -------------------------- |
| `id`         | integer   | Province unique identifier |
| `name`       | string    | Province name              |
| `created_at` | timestamp | Creation timestamp         |
| `updated_at` | timestamp | Last update timestamp      |

### Example Destination Object

```json
{
    "id": 1,
    "name": "Sigiriya Rock Fortress",
    "province_id": 3,
    "image": "https://your-domain.com/storage/destinations/sigiriya.jpg",
    "attractions": [
        "Ancient Rock Fortress",
        "Frescoes Gallery",
        "Mirror Wall",
        "Lion's Gate",
        "Summit Gardens"
    ],
    "description": "Sigiriya is an ancient rock fortress located in the northern Matale District near the town of Dambulla in the Central Province, Sri Lanka. It is a UNESCO World Heritage Site and one of the best preserved examples of ancient urban planning.",
    "label": "UNESCO World Heritage",
    "status": "active",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-20T14:45:00.000000Z",
    "province": {
        "id": 3,
        "name": "Central Province",
        "created_at": "2024-01-10T08:00:00.000000Z",
        "updated_at": "2024-01-10T08:00:00.000000Z"
    }
}
```

---

## API Endpoints

### Public API

#### 1. Get All Destinations

Retrieve a list of all destinations with province information and full image URLs.

**Endpoint**: `GET /api/v1/destinations`

**Headers**:

```
Accept: application/json
```

**Query Parameters**:

| Parameter     | Type    | Required | Description                        |
| ------------- | ------- | -------- | ---------------------------------- |
| `province_id` | integer | No       | Filter destinations by province ID |

**Response**: `200 OK`

**Example 1: Get All Destinations**

```bash
GET /api/v1/destinations
```

```json
[
    {
        "id": 1,
        "name": "Sigiriya Rock Fortress",
        "province_id": 3,
        "image": "https://your-domain.com/storage/destinations/sigiriya.jpg",
        "attractions": [
            "Ancient Rock Fortress",
            "Frescoes Gallery",
            "Mirror Wall"
        ],
        "description": "Ancient rock fortress and UNESCO World Heritage Site",
        "label": "UNESCO World Heritage",
        "status": "active",
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-20T14:45:00.000000Z",
        "province": {
            "id": 3,
            "name": "Central Province",
            "created_at": "2024-01-10T08:00:00.000000Z",
            "updated_at": "2024-01-10T08:00:00.000000Z"
        }
    },
    {
        "id": 2,
        "name": "Galle Fort",
        "province_id": 5,
        "image": "https://your-domain.com/storage/destinations/galle-fort.jpg",
        "attractions": [
            "Dutch Fort",
            "Lighthouse",
            "Clock Tower",
            "Maritime Museum"
        ],
        "description": "Historic fortification built by the Portuguese and later fortified by the Dutch",
        "label": "Colonial Heritage",
        "status": "active",
        "created_at": "2024-01-16T11:00:00.000000Z",
        "updated_at": "2024-01-21T09:30:00.000000Z",
        "province": {
            "id": 5,
            "name": "Southern Province",
            "created_at": "2024-01-10T08:00:00.000000Z",
            "updated_at": "2024-01-10T08:00:00.000000Z"
        }
    }
]
```

**Example 2: Filter by Province**

```bash
GET /api/v1/destinations?province_id=3
```

```json
[
    {
        "id": 1,
        "name": "Sigiriya Rock Fortress",
        "province_id": 3,
        "image": "https://your-domain.com/storage/destinations/sigiriya.jpg",
        "attractions": ["Ancient Rock Fortress", "Frescoes Gallery"],
        "description": "Ancient rock fortress and UNESCO World Heritage Site",
        "label": "UNESCO World Heritage",
        "status": "active",
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-20T14:45:00.000000Z",
        "province": {
            "id": 3,
            "name": "Central Province",
            "created_at": "2024-01-10T08:00:00.000000Z",
            "updated_at": "2024-01-10T08:00:00.000000Z"
        }
    },
    {
        "id": 3,
        "name": "Temple of the Tooth",
        "province_id": 3,
        "image": "https://your-domain.com/storage/destinations/temple-tooth.jpg",
        "attractions": [
            "Sacred Tooth Relic",
            "Buddhist Temple",
            "Royal Palace Complex"
        ],
        "description": "Buddhist temple in Kandy housing the relic of the tooth of the Buddha",
        "label": "Sacred Site",
        "status": "active",
        "created_at": "2024-01-17T12:00:00.000000Z",
        "updated_at": "2024-01-22T10:00:00.000000Z",
        "province": {
            "id": 3,
            "name": "Central Province",
            "created_at": "2024-01-10T08:00:00.000000Z",
            "updated_at": "2024-01-10T08:00:00.000000Z"
        }
    }
]
```

**Implementation Details**:

- Returns all destinations ordered by latest first
- Includes related province information via eager loading
- Image URLs are automatically converted to full URLs
- No pagination applied
- Filter by `province_id` to get destinations in a specific province

---

#### 2. Get Single Destination

Retrieve detailed information about a specific destination.

**Endpoint**: `GET /api/v1/destinations/{id}`

**Headers**:

```
Accept: application/json
```

**URL Parameters**:

| Parameter | Type    | Required | Description    |
| --------- | ------- | -------- | -------------- |
| `id`      | integer | Yes      | Destination ID |

**Response**: `200 OK`

```json
{
    "id": 1,
    "name": "Sigiriya Rock Fortress",
    "province_id": 3,
    "image": "https://your-domain.com/storage/destinations/sigiriya.jpg",
    "attractions": [
        "Ancient Rock Fortress",
        "Frescoes Gallery",
        "Mirror Wall",
        "Lion's Gate",
        "Summit Gardens"
    ],
    "description": "Sigiriya is an ancient rock fortress located in the northern Matale District near the town of Dambulla in the Central Province, Sri Lanka. It is a UNESCO World Heritage Site and one of the best preserved examples of ancient urban planning.",
    "label": "UNESCO World Heritage",
    "status": "active",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-20T14:45:00.000000Z",
    "province": {
        "id": 3,
        "name": "Central Province",
        "created_at": "2024-01-10T08:00:00.000000Z",
        "updated_at": "2024-01-10T08:00:00.000000Z"
    }
}
```

**Error Response**: `404 Not Found`

```json
{
    "message": "No query results for model [App\\Models\\Destination] {id}"
}
```

---

### Admin API (Web Routes)

All admin endpoints require authentication via `auth` middleware.

#### 3. List Destinations (Admin View)

Display paginated list of destinations with search functionality.

**Endpoint**: `GET /destinations`

**Authentication**: Required

**Query Parameters**:

| Parameter | Type    | Required | Description                |
| --------- | ------- | -------- | -------------------------- |
| `search`  | string  | No       | Search by destination name |
| `page`    | integer | No       | Page number (default: 1)   |

**Response**: Returns Blade view with paginated destinations (10 per page)

**Example Request**:

```
GET /destinations?search=sigiriya&page=1
```

---

#### 4. Show Create Form

Display form to create a new destination.

**Endpoint**: `GET /destinations/create`

**Authentication**: Required

**Response**: Returns Blade view with create form and list of provinces

---

#### 5. Create Destination

Store a new destination in the database.

**Endpoint**: `POST /destinations`

**Authentication**: Required

**Headers**:

```
Content-Type: multipart/form-data
X-CSRF-TOKEN: {csrf_token}
```

**Request Body**:

| Field         | Type    | Required | Validation          |
| ------------- | ------- | -------- | ------------------- |
| `name`        | string  | Yes      | max:255             |
| `province_id` | integer | Yes      | exists:provinces,id |
| `image`       | file    | No       | image, max:5MB      |
| `attractions` | array   | No       | -                   |
| `description` | text    | No       | -                   |
| `label`       | string  | No       | max:255             |
| `status`      | string  | Yes      | active or inactive  |

**Example Request** (Form Data):

```
name: Sigiriya Rock Fortress
province_id: 3
image: [file upload]
attractions[0]: Ancient Rock Fortress
attractions[1]: Frescoes Gallery
attractions[2]: Mirror Wall
description: Ancient rock fortress and UNESCO World Heritage Site
label: UNESCO World Heritage
status: active
```

**Success Response**: `302 Redirect`

```
Redirects to: /destinations
Flash Message: "Destination created successfully."
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
        "province_id": ["The selected province id is invalid."]
    }
}
```

**Implementation Notes**:

- Uses database transaction for data integrity
- Image stored in `storage/app/public/destinations/` directory
- Attractions stored as JSON array
- Automatic rollback on error

---

#### 6. Show Edit Form

Display form to edit an existing destination.

**Endpoint**: `GET /destinations/{id}/edit`

**Authentication**: Required

**URL Parameters**:

| Parameter | Type    | Required | Description    |
| --------- | ------- | -------- | -------------- |
| `id`      | integer | Yes      | Destination ID |

**Response**: Returns Blade view with edit form, destination data, and list of provinces

**Error Response**: `404 Not Found` if destination doesn't exist

---

#### 7. Update Destination

Update an existing destination.

**Endpoint**: `PUT /destinations/{id}` or `POST /destinations/{id}` with `_method=PUT`

**Authentication**: Required

**Headers**:

```
Content-Type: multipart/form-data
X-CSRF-TOKEN: {csrf_token}
```

**URL Parameters**:

| Parameter | Type    | Required | Description    |
| --------- | ------- | -------- | -------------- |
| `id`      | integer | Yes      | Destination ID |

**Request Body**: Same as Create Destination

**Example Request** (Form Data):

```
_method: PUT
name: Sigiriya Rock Fortress - Updated
province_id: 3
image: [optional new file upload]
attractions[0]: Ancient Rock Fortress
attractions[1]: Frescoes Gallery
attractions[2]: Mirror Wall
attractions[3]: Lion's Gate
description: Updated description
label: UNESCO World Heritage
status: active
```

**Success Response**: `302 Redirect`

```
Redirects to: /destinations
Flash Message: "Destination updated successfully."
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

#### 8. Delete Destination

Delete a destination from the database.

**Endpoint**: `DELETE /destinations/{id}` or `POST /destinations/{id}` with `_method=DELETE`

**Authentication**: Required

**Headers**:

```
X-CSRF-TOKEN: {csrf_token}
```

**URL Parameters**:

| Parameter | Type    | Required | Description    |
| --------- | ------- | -------- | -------------- |
| `id`      | integer | Yes      | Destination ID |

**Success Response**: `302 Redirect`

```
Redirects to: /destinations
Flash Message: "Destination deleted."
```

**Error Response**: `404 Not Found` if destination doesn't exist

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
| `404` | Destination not found                 |
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

### Example 1: Fetch All Destinations (Public API)

**Request**:

```bash
curl -X GET "https://your-domain.com/api/v1/destinations" \
  -H "Accept: application/json"
```

**Response**:

```json
[
    {
        "id": 1,
        "name": "Sigiriya Rock Fortress",
        "province_id": 3,
        "image": "https://your-domain.com/storage/destinations/sigiriya.jpg",
        "attractions": ["Ancient Rock Fortress", "Frescoes Gallery"],
        "description": "Ancient rock fortress and UNESCO World Heritage Site",
        "label": "UNESCO World Heritage",
        "status": "active",
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-20T14:45:00.000000Z",
        "province": {
            "id": 3,
            "name": "Central Province",
            "created_at": "2024-01-10T08:00:00.000000Z",
            "updated_at": "2024-01-10T08:00:00.000000Z"
        }
    }
]
```

---

### Example 2: Filter Destinations by Province

**Request**:

```bash
curl -X GET "https://your-domain.com/api/v1/destinations?province_id=3" \
  -H "Accept: application/json"
```

**Response**: Returns only destinations in province ID 3 (Central Province)

---

### Example 3: Get Single Destination

**Request**:

```bash
curl -X GET "https://your-domain.com/api/v1/destinations/1" \
  -H "Accept: application/json"
```

**Response**:

```json
{
    "id": 1,
    "name": "Sigiriya Rock Fortress",
    "province_id": 3,
    "image": "https://your-domain.com/storage/destinations/sigiriya.jpg",
    "attractions": ["Ancient Rock Fortress", "Frescoes Gallery", "Mirror Wall"],
    "description": "Ancient rock fortress and UNESCO World Heritage Site",
    "label": "UNESCO World Heritage",
    "status": "active",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-20T14:45:00.000000Z",
    "province": {
        "id": 3,
        "name": "Central Province",
        "created_at": "2024-01-10T08:00:00.000000Z",
        "updated_at": "2024-01-10T08:00:00.000000Z"
    }
}
```

---

### Example 4: Create Destination (Admin)

**Request**:

```bash
curl -X POST "https://your-domain.com/destinations" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -H "Cookie: laravel_session=your-session-cookie" \
  -F "name=Yala National Park" \
  -F "province_id=7" \
  -F "image=@/path/to/yala.jpg" \
  -F "attractions[0]=Wildlife Safari" \
  -F "attractions[1]=Leopard Spotting" \
  -F "attractions[2]=Bird Watching" \
  -F "description=Famous national park known for leopards and elephants" \
  -F "label=Wildlife" \
  -F "status=active"
```

**Response**: Redirects to `/destinations` with success message

---

### Example 5: Update Destination (Admin)

**Request**:

```bash
curl -X POST "https://your-domain.com/destinations/1" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -H "Cookie: laravel_session=your-session-cookie" \
  -F "_method=PUT" \
  -F "name=Sigiriya Rock Fortress - Updated" \
  -F "province_id=3" \
  -F "attractions[0]=Ancient Rock Fortress" \
  -F "attractions[1]=Frescoes Gallery" \
  -F "attractions[2]=Mirror Wall" \
  -F "attractions[3]=Lion's Gate" \
  -F "description=Updated description with more details" \
  -F "label=UNESCO World Heritage" \
  -F "status=active"
```

**Response**: Redirects to `/destinations` with success message

---

### Example 6: Delete Destination (Admin)

**Request**:

```bash
curl -X POST "https://your-domain.com/destinations/1" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -H "Cookie: laravel_session=your-session-cookie" \
  -F "_method=DELETE"
```

**Response**: Redirects to `/destinations` with success message

---

## JavaScript/Axios Examples

### Fetch All Destinations (Public API)

```javascript
// Using Axios
axios
    .get("https://your-domain.com/api/v1/destinations")
    .then((response) => {
        console.log("Destinations:", response.data);
        response.data.forEach((destination) => {
            console.log(`${destination.name} - ${destination.province.name}`);
            console.log("Attractions:", destination.attractions);
        });
    })
    .catch((error) => {
        console.error("Error fetching destinations:", error);
    });

// Using Fetch API
fetch("https://your-domain.com/api/v1/destinations")
    .then((response) => response.json())
    .then((data) => {
        console.log("Destinations:", data);
    })
    .catch((error) => {
        console.error("Error:", error);
    });
```

### Filter Destinations by Province

```javascript
// Get destinations in Central Province (province_id = 3)
axios
    .get("https://your-domain.com/api/v1/destinations", {
        params: {
            province_id: 3,
        },
    })
    .then((response) => {
        console.log("Central Province Destinations:", response.data);
    })
    .catch((error) => {
        console.error("Error:", error);
    });
```

### Get Single Destination

```javascript
const destinationId = 1;

axios
    .get(`https://your-domain.com/api/v1/destinations/${destinationId}`)
    .then((response) => {
        const destination = response.data;
        console.log("Destination:", destination.name);
        console.log("Province:", destination.province.name);
        console.log("Attractions:", destination.attractions);
        console.log("Image:", destination.image);
    })
    .catch((error) => {
        if (error.response && error.response.status === 404) {
            console.error("Destination not found");
        } else {
            console.error("Error:", error);
        }
    });
```

### Create Destination (Admin - with CSRF)

```javascript
// Get CSRF token from meta tag
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Create FormData
const formData = new FormData();
formData.append("name", "Yala National Park");
formData.append("province_id", 7);
formData.append("description", "Famous national park known for leopards");
formData.append("label", "Wildlife");
formData.append("status", "active");

// Add attractions array
formData.append("attractions[0]", "Wildlife Safari");
formData.append("attractions[1]", "Leopard Spotting");
formData.append("attractions[2]", "Bird Watching");

// If you have an image file input
const imageInput = document.querySelector("#image");
if (imageInput.files[0]) {
    formData.append("image", imageInput.files[0]);
}

// Send request
axios
    .post("/destinations", formData, {
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Content-Type": "multipart/form-data",
        },
    })
    .then((response) => {
        console.log("Destination created successfully");
        window.location.href = "/destinations";
    })
    .catch((error) => {
        console.error("Error creating destination:", error.response.data);
    });
```

### Dynamic Province Filter (React/Vue Example)

```javascript
// React Component Example
import { useState, useEffect } from "react";
import axios from "axios";

function DestinationList() {
    const [destinations, setDestinations] = useState([]);
    const [provinces, setProvinces] = useState([]);
    const [selectedProvince, setSelectedProvince] = useState("");
    const [loading, setLoading] = useState(false);

    // Fetch provinces on mount
    useEffect(() => {
        axios
            .get("/api/provinces")
            .then((response) => setProvinces(response.data))
            .catch((error) =>
                console.error("Error fetching provinces:", error),
            );
    }, []);

    // Fetch destinations when province filter changes
    useEffect(() => {
        setLoading(true);
        const params = selectedProvince
            ? { province_id: selectedProvince }
            : {};

        axios
            .get("https://your-domain.com/api/v1/destinations", { params })
            .then((response) => {
                setDestinations(response.data);
                setLoading(false);
            })
            .catch((error) => {
                console.error("Error fetching destinations:", error);
                setLoading(false);
            });
    }, [selectedProvince]);

    return (
        <div>
            <select
                value={selectedProvince}
                onChange={(e) => setSelectedProvince(e.target.value)}
            >
                <option value="">All Provinces</option>
                {provinces.map((province) => (
                    <option key={province.id} value={province.id}>
                        {province.name}
                    </option>
                ))}
            </select>

            {loading ? (
                <p>Loading...</p>
            ) : (
                <ul>
                    {destinations.map((destination) => (
                        <li key={destination.id}>
                            <h3>{destination.name}</h3>
                            <p>{destination.province.name}</p>
                            <img
                                src={destination.image}
                                alt={destination.name}
                            />
                            <ul>
                                {destination.attractions.map(
                                    (attraction, index) => (
                                        <li key={index}>{attraction}</li>
                                    ),
                                )}
                            </ul>
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
}
```

---

## Province API Integration

To effectively use the destination filtering, you'll need to fetch available provinces first.

### Get All Provinces

**Endpoint**: `GET /api/provinces` (if available)

**Example**:

```javascript
axios.get("/api/provinces").then((response) => {
    const provinces = response.data;
    // Use provinces to populate dropdown filter
});
```

---

## Image Handling

### Image Upload

- **Accepted formats**: JPG, JPEG, PNG, GIF, SVG, WEBP
- **Maximum size**: 5MB (5120KB)
- **Storage location**: `storage/app/public/destinations/`
- **Public URL**: `https://your-domain.com/storage/destinations/{filename}`

### Image URL Conversion

The API automatically converts relative storage paths to full URLs:

- **Stored in DB**: `destinations/abc123.jpg`
- **Returned by API**: `https://your-domain.com/storage/destinations/abc123.jpg`

### Image Deletion

- When updating a destination with a new image, the old image is automatically deleted
- When deleting a destination, the associated image is automatically deleted

---

## Attractions Array Handling

Attractions are stored as a JSON array in the database. When creating or updating destinations:

### Form Data Format

```
attractions[0]: First Attraction
attractions[1]: Second Attraction
attractions[2]: Third Attraction
```

### JSON Format (API)

```json
{
    "attractions": ["First Attraction", "Second Attraction", "Third Attraction"]
}
```

---

## Best Practices

1. **Filter by Province**: Use `province_id` parameter to reduce data transfer and improve performance
2. **Cache Province Data**: Provinces rarely change, so cache them on the client side
3. **Lazy Load Images**: Load destination images progressively for better UX
4. **Validate Province ID**: Always validate that the selected province exists before creating/updating
5. **Handle Empty Attractions**: Check if attractions array exists before iterating
6. **Optimize Images**: Compress images before uploading to reduce storage and bandwidth
7. **Implement Pagination**: For large datasets, consider implementing pagination on the API
8. **Error Handling**: Always handle 404 errors when fetching single destinations

---

## Common Use Cases

### Use Case 1: Province-Based Destination Selector

```javascript
// Step 1: User selects a province
const provinceId = 3; // Central Province

// Step 2: Fetch destinations for that province
axios
    .get(
        `https://your-domain.com/api/v1/destinations?province_id=${provinceId}`,
    )
    .then((response) => {
        // Display filtered destinations
        displayDestinations(response.data);
    });
```

### Use Case 2: Destination Detail Page

```javascript
// Get destination ID from URL
const destinationId = window.location.pathname.split("/").pop();

// Fetch full destination details
axios
    .get(`https://your-domain.com/api/v1/destinations/${destinationId}`)
    .then((response) => {
        const dest = response.data;

        // Display destination info
        document.getElementById("name").textContent = dest.name;
        document.getElementById("province").textContent = dest.province.name;
        document.getElementById("description").textContent = dest.description;
        document.getElementById("image").src = dest.image;

        // Display attractions
        const attractionsList = document.getElementById("attractions");
        dest.attractions.forEach((attraction) => {
            const li = document.createElement("li");
            li.textContent = attraction;
            attractionsList.appendChild(li);
        });
    })
    .catch((error) => {
        if (error.response && error.response.status === 404) {
            // Redirect to 404 page or show error message
            window.location.href = "/404";
        }
    });
```

### Use Case 3: Multi-Province Destination Map

```javascript
// Fetch all destinations
axios.get("https://your-domain.com/api/v1/destinations").then((response) => {
    // Group destinations by province
    const destinationsByProvince = response.data.reduce((acc, dest) => {
        const provinceName = dest.province.name;
        if (!acc[provinceName]) {
            acc[provinceName] = [];
        }
        acc[provinceName].push(dest);
        return acc;
    }, {});

    // Display grouped destinations
    console.log(destinationsByProvince);
});
```

---

## Rate Limiting

Currently, no rate limiting is implemented. Consider implementing rate limiting for production:

```php
// In routes/api.php
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/destinations', [ApiController::class, 'destinations']);
    Route::get('/destinations/{id}', [ApiController::class, 'destinationShow']);
});
```

---

## Changelog

### Version 1.0.1 (Current)

- Added `province_id` filter parameter to destinations endpoint
- Improved query performance with eager loading

### Version 1.0.0

- Initial API implementation
- CRUD operations for destinations
- Public API endpoints for listing and viewing destinations
- Image upload and management
- Search functionality
- Province relationship support

---

## Support

For issues or questions, please contact the development team or create an issue in the project repository.

---

**Last Updated**: January 2026  
**API Version**: 1.0.1  
**Laravel Version**: 10.x+
