# Figo Holidays - API Documentation v1.1

This API provides read-only access to all content managed via the Figo Holidays Admin Panel. All endpoints return JSON data and include absolute URLs for all image assets.

**Base URL:** `{{your-domain}}/api/v1`

---

## 🏠 Home Page (Main Banner)

`GET /heroes`

Returns the single home page design configuration. This endpoint is now optimized for a dynamic background slider and custom typography.

### Response Structure:

```json
{
    "tag": "Exclusive 2026 Offers",
    "tag_size": "14",
    "title": "Sri Lanka through",
    "title_size": "45",
    "highlighted_title": "Arab lensan",
    "highlight_size": "45",
    "description": "Luxury trips designed specifically for the Gulf traveler.",
    "description_size": "16",
    "background_image": "http://.../storage/heroes/backgrounds/poster.jpg",
    "background_images": [
        "http://.../storage/heroes/slider/bg1.jpg",
        "http://.../storage/heroes/slider/bg2.jpg"
    ],
    "btn1_text": "Free consultation",
    "btn1_url": "https://...",
    "btn1_icon": "http://.../storage/heroes/icons/icon1.png",
    "btn2_text": "Browse programs",
    "btn2_url": "https://...",
    "btn2_icon": "http://.../storage/heroes/icons/icon2.png"
}
```

_Note: Font sizes are returned as raw pixel values (0-100)._

---

## � Transportation Page

`GET /transportation-page`

Returns the content for the transportation landing page/menu.

### Response Structure:

```json
{
    "id": 1,
    "main_title": "Car Rental with Driver",
    "main_subtitle": "Starting from $60 in Sri Lanka",
    "image_01": "http://.../storage/transportation/banner1.jpg",
    "image_02": "http://.../storage/transportation/banner2.jpg",
    "faqs": [
        {
            "question": "Are fuel costs included?",
            "answer": "Yes, fuel and driver charges are included."
        },
        {
            "question": "Can we change the route?",
            "answer": "Yes, routes can be customized upon request."
        }
    ]
}
```

---

## 📍 Destinations

- **List all**: `GET /destinations`
- **Show one**: `GET /destinations/{id}`

### Response Structure:

```json
{
    "id": 5,
    "name": "Kandy",
    "image": "http://.../storage/destinations/kandy.jpg",
    "province_id": 2,
    "label": "Heritage City",
    "description": "The cultural capital of Sri Lanka...",
    "attractions": [
        {
            "title": "Temple of the Tooth",
            "image": "http://.../storage/destinations/attractions/temple.jpg"
        },
        {
            "title": "Royal Botanical Gardens",
            "image": "http://.../storage/destinations/attractions/gardens.jpg"
        }
    ],
    "province": {
        "id": 2,
        "name": "Central Province"
    }
}
```

---

## 🚗 Transportation List (Fleet)

`GET /transportations`

Returns the list of available vehicles and fleet details.

### Response Structure:

```json
[
    {
        "id": 1,
        "name": "Luxury Sedan",
        "type": "Car",
        "image": "http://.../storage/transportation/vehicles/sedan.png",
        "pricePerDay": "65",
        "seats": 4,
        "bags": 2,
        "includes": ["Driver", "Insurance", "Fuel"]
    }
]
```

---

## �️ General Information

### Image URLs

All images are returned as absolute URLs pointing to the public storage.
`Example: http://domain.com/storage/path/to/image.jpg`

### Data Casting

- `faqs`, `attractions`, and `background_images` are returned as native JSON arrays.
- Font sizes in the Home Page object are strings representing numeric pixel values.

---

© 2026 FIGO HOLIDAYS
**Documentation Updated:** Jan 31, 2026
**Lead Dev:** MHMD Faiz
