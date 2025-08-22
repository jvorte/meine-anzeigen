
# Meine Anzeigen

**Meine Anzeigen** is a multi-category classifieds web application running in production. It allows users to create, browse, and manage ads across categories such as vehicles, electronics, real estate, services, and more. The platform is designed for scalability, multilingual support, and a modern, responsive user experience.

---

<img width="1863" height="871" alt="image" src="https://github.com/user-attachments/assets/1efd9c4b-cd05-4446-b288-42ae160eda66" />




## Key Features

- **Multi-category classifieds**: Vehicles, electronics, real estate, services, and more.
- **Dynamic forms**: Category-specific input fields using Alpine.js.
- **Multilingual support**: English and German content with seamless language switching.
- **User authentication**: Secure registration, login, and profile management.
- **Ad management**: Users can create, edit, and delete their own ads.
- **Media support**: Upload multiple images, including 360° views.
- **Advanced filtering**: Search and filter ads based on category-specific attributes.
- **Responsive design**: Optimized for both desktop and mobile using Tailwind CSS.

---

## Technology Stack

- **Backend**: Laravel 10
- **Frontend**: Blade templates + Alpine.js
- **Styling**: Tailwind CSS
- **Database**: MySQL / MariaDB
- **Authentication**: Laravel Breeze
- **Localization**: Laravel language files (EN/DE)
- **File storage**: Local or cloud via Laravel filesystem

---

## Architecture Overview

- **Models**: Separate models per category (e.g., Vehicle, Electronic, RealEstate) with dynamic relationships for images and attributes.
- **Controllers**: Dedicated controllers handle CRUD operations per category.
- **Frontend**: Blade + Alpine.js for dynamic forms, tabs, and filters.
- **Routing**: RESTful routes for all ads and categories.
- **Localization**: Category names, form fields, and labels translated via Laravel language files.
- **UI/UX**: Tailwind CSS for responsive layouts and clean card-based design.

---

## Repository Purpose

This repository serves as the **source of truth** for the Meine Anzeigen production web application. It tracks all backend logic, frontend components, and translations. It is **not intended for public deployment or cloning**, but for internal development, maintenance, and version control.
