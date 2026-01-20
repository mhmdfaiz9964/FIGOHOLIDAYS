# Figo Holidays - API Documentation

This API provides read-only access to all content managed via the Figo Holidays Admin Panel. All endpoints return JSON data and include full URLs for all image assets.

**Base URL:** `{{your-domain}}/api/v1`

---

## 🛠️ General Endpoints

### 1. Site Settings

`GET /settings`
Returns global branding, multiple contact details, social links, and the dynamic theme color.

### 2. Visa Information

`GET /visa`
Returns the singleton visa page content including hero background and procedure card images.

### 3. Homepage Heroes (Banners)

`GET /heroes`
Returns a list of all banner images and their titles.

### 4. Partners & Corporate Clients

`GET /partners`
Returns all partner logos and information.

---

## 🗺️ Travel & Listings

### 5. Offer Categories

`GET /categories`
Returns categories like "Luxury Tours", "Family Holidays", etc.

### 6. Travel Offers

- **List all**: `GET /offers`
- **Show one**: `GET /offers/{id}`
  Includes related category, package types, and full daily itinerary.

### 7. Hotels & Accommodations

- **List all**: `GET /hotels`
- **Show one**: `GET /hotels/{id}`
  Includes hotel types and the JSON list of activities/amenities.

### 8. Destinations

- **List all**: `GET /destinations`
- **Show one**: `GET /destinations/{id}`
  Includes the related province and detailed description.

---

## 🍽️ Services & Social

### 9. Restaurants

`GET /restaurants`
Returns list of recommended dining locations with ratings and images.

### 10. Transportation

`GET /transportations`
Returns vehicle types and transportation services.

### 11. Guest Reviews

`GET /reviews`
Returns customer feedback, star ratings, and user profile images.

### 12. FAQs

`GET /faqs`
Returns frequently asked questions and their answers.

---

## 🖼️ Image Handling

All images are returned as absolute URLs.
Example output:

```json
{
    "logo": "http://127.0.0.1:8000/storage/settings/logo.png",
    "image": "http://127.0.0.1:8000/storage/offers/cover.jpg"
}
```

---

© 2026 APEX WEB INNOVATION.
**Lead Dev:** MHMD Faiz
