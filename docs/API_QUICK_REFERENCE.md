# API Quick Reference Guide

## Restaurant & Destination APIs - FIGO Holidays

This document provides a quick reference for the Restaurant and Destination public APIs.

---

## Base URL

```
https://your-domain.com/api/v1
```

---

## Restaurant API

### Get All Restaurants

**Endpoint**: `GET /api/v1/restaurants`

**Query Parameters**:

| Parameter | Type   | Required | Description                                              |
| --------- | ------ | -------- | -------------------------------------------------------- |
| `type`    | string | No       | Filter by cuisine type (partial match, case-insensitive) |

**Examples**:

```bash
# Get all restaurants
GET /api/v1/restaurants

# Filter by cuisine type
GET /api/v1/restaurants?type=italian
GET /api/v1/restaurants?type=seafood
GET /api/v1/restaurants?type=asian
```

**Response Fields**:

- `id` - Restaurant ID
- `name` - Restaurant name
- `type` - Cuisine type
- `rating` - Rating (1-5)
- `map_url` - Google Maps URL
- `image` - Full image URL
- `description` - Description
- `status` - Status (active/inactive)
- `created_at` - Creation timestamp
- `updated_at` - Update timestamp

---

## Destination API

### Get All Destinations

**Endpoint**: `GET /api/v1/destinations`

**Query Parameters**:

| Parameter     | Type    | Required | Description                         |
| ------------- | ------- | -------- | ----------------------------------- |
| `province_id` | integer | No       | Filter by province ID (exact match) |

**Examples**:

```bash
# Get all destinations
GET /api/v1/destinations

# Filter by province
GET /api/v1/destinations?province_id=3
GET /api/v1/destinations?province_id=5
```

**Response Fields**:

- `id` - Destination ID
- `name` - Destination name
- `province_id` - Province ID
- `image` - Full image URL
- `attractions` - Array of attractions
- `description` - Description
- `label` - Label/tag
- `status` - Status (active/inactive)
- `created_at` - Creation timestamp
- `updated_at` - Update timestamp
- `province` - Province object with `id` and `name`

### Get Single Destination

**Endpoint**: `GET /api/v1/destinations/{id}`

**URL Parameters**:

| Parameter | Type    | Required | Description    |
| --------- | ------- | -------- | -------------- |
| `id`      | integer | Yes      | Destination ID |

**Example**:

```bash
GET /api/v1/destinations/1
```

---

## JavaScript Examples

### Fetch Restaurants

```javascript
// Get all restaurants
axios
    .get("https://your-domain.com/api/v1/restaurants")
    .then((response) => console.log(response.data));

// Filter by cuisine type
axios
    .get("https://your-domain.com/api/v1/restaurants", {
        params: { type: "italian" },
    })
    .then((response) => console.log(response.data));
```

### Fetch Destinations

```javascript
// Get all destinations
axios
    .get("https://your-domain.com/api/v1/destinations")
    .then((response) => console.log(response.data));

// Filter by province
axios
    .get("https://your-domain.com/api/v1/destinations", {
        params: { province_id: 3 },
    })
    .then((response) => console.log(response.data));

// Get single destination
axios
    .get("https://your-domain.com/api/v1/destinations/1")
    .then((response) => console.log(response.data));
```

---

## Common Response Format

All endpoints return JSON responses with appropriate HTTP status codes:

- `200 OK` - Success
- `404 Not Found` - Resource not found
- `500 Internal Server Error` - Server error

---

## Image URLs

All image paths are automatically converted to full URLs:

**Example**:

```json
{
    "image": "https://your-domain.com/storage/restaurants/image.jpg"
}
```

---

## Rate Limiting

Currently no rate limiting is implemented. Consider implementing for production use.

---

## Full Documentation

For complete API documentation including admin endpoints, validation rules, and detailed examples:

- **Restaurant API**: See `RESTAURANT_API_DOCUMENTATION.md`
- **Destination API**: See `DESTINATION_API_DOCUMENTATION.md`

---

**Last Updated**: January 2026  
**API Version**: 1.0.1
