# FIGO Holidays API Documentation

Welcome to the FIGO Holidays API documentation. This directory contains comprehensive documentation for all available APIs.

## 📚 Available Documentation

### 1. [API Quick Reference](API_QUICK_REFERENCE.md)

**Quick lookup guide** for Restaurant and Destination APIs with all available endpoints and filters.

**Use this when**: You need a quick reference for endpoint URLs and parameters.

---

### 2. [Restaurant API Documentation](RESTAURANT_API_DOCUMENTATION.md)

**Complete documentation** for the Restaurant API including:

- ✅ Public API endpoints
- ✅ Admin CRUD operations
- ✅ Cuisine type filtering
- ✅ Image upload/management
- ✅ Validation rules
- ✅ JavaScript/React examples
- ✅ Error handling

**Use this when**: You need detailed information about restaurant endpoints, validation, or implementation examples.

---

### 3. [Destination API Documentation](DESTINATION_API_DOCUMENTATION.md)

**Complete documentation** for the Destination API including:

- ✅ Public API endpoints
- ✅ Admin CRUD operations
- ✅ Province filtering
- ✅ Attractions management
- ✅ Image upload/management
- ✅ Validation rules
- ✅ JavaScript/React examples
- ✅ Error handling

**Use this when**: You need detailed information about destination endpoints, province relationships, or implementation examples.

---

## 🚀 Quick Start

### Public API Base URL

```
https://your-domain.com/api/v1
```

### Available Endpoints

#### Restaurants

```bash
# Get all restaurants
GET /api/v1/restaurants

# Filter by cuisine type
GET /api/v1/restaurants?type=italian
```

#### Destinations

```bash
# Get all destinations
GET /api/v1/destinations

# Filter by province
GET /api/v1/destinations?province_id=3

# Get single destination
GET /api/v1/destinations/{id}
```

---

## 📋 API Features

### Restaurant API

- **Filter by cuisine type**: Search for restaurants by cuisine (Italian, Asian, Seafood, etc.)
- **Full CRUD operations**: Create, read, update, and delete restaurants (admin only)
- **Image management**: Upload and manage restaurant images
- **Rating system**: 1-5 star ratings

### Destination API

- **Filter by province**: Get destinations in a specific province
- **Attractions array**: Multiple attractions per destination
- **Province relationship**: Each destination belongs to a province
- **Full CRUD operations**: Create, read, update, and delete destinations (admin only)
- **Image management**: Upload and manage destination images

---

## 🔐 Authentication

### Public Endpoints

- **No authentication required** for GET requests to public API endpoints

### Admin Endpoints

- **Authentication required** via Laravel session/Sanctum
- **CSRF token required** for POST, PUT, DELETE requests

---

## 📝 Response Format

All API responses are in JSON format:

```json
{
    "id": 1,
    "name": "Example",
    "image": "https://your-domain.com/storage/path/to/image.jpg",
    "status": "active",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-20T14:45:00.000000Z"
}
```

---

## 🛠️ Common Use Cases

### 1. Display Restaurants by Cuisine Type

```javascript
axios
    .get("/api/v1/restaurants", {
        params: { type: "italian" },
    })
    .then((response) => {
        displayRestaurants(response.data);
    });
```

### 2. Display Destinations by Province

```javascript
axios
    .get("/api/v1/destinations", {
        params: { province_id: 3 },
    })
    .then((response) => {
        displayDestinations(response.data);
    });
```

### 3. Get Destination Details

```javascript
axios.get("/api/v1/destinations/1").then((response) => {
    const destination = response.data;
    console.log(destination.name);
    console.log(destination.province.name);
    console.log(destination.attractions);
});
```

---

## 📊 HTTP Status Codes

| Code  | Description                           |
| ----- | ------------------------------------- |
| `200` | Success                               |
| `302` | Redirect (after successful operation) |
| `404` | Resource not found                    |
| `422` | Validation error                      |
| `500` | Server error                          |

---

## 🖼️ Image Handling

### Image Upload Specifications

- **Accepted formats**: JPG, JPEG, PNG, GIF, SVG, WEBP
- **Maximum size**: 5MB (5120KB)
- **Storage location**: `storage/app/public/{module}/`
- **Public URL**: Automatically converted to full URLs

### Example

```json
{
    "image": "https://your-domain.com/storage/restaurants/image.jpg"
}
```

---

## 🔄 API Versions

### Current Version: 1.0.1

**Restaurant API Changes (v1.0.1)**:

- Added `type` query parameter for filtering by cuisine type

**Destination API Changes (v1.0.1)**:

- Added `province_id` query parameter for filtering by province

---

## 💡 Best Practices

1. **Use filters** to reduce data transfer and improve performance
2. **Cache static data** (provinces, etc.) on the client side
3. **Handle errors gracefully** with proper error messages
4. **Validate input** on the client side before sending requests
5. **Optimize images** before uploading to reduce storage
6. **Implement pagination** for large datasets in your client app

---

## 📞 Support

For issues, questions, or feature requests:

- Contact the development team
- Create an issue in the project repository

---

## 📖 Additional Resources

- Laravel Documentation: https://laravel.com/docs
- Axios Documentation: https://axios-http.com/docs/intro
- React Documentation: https://react.dev

---

**Last Updated**: January 2026  
**API Version**: 1.0.1  
**Laravel Version**: 10.x+
