# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

"Mariposas" is a Laravel 11 application with dual interfaces:
1. **Filament 3 Admin Panel** (`/panel`) - For administrators to manage the system
2. **Member Dashboard** (`/dashboard`) - Modern, reactive interface for members built with Livewire + Alpine.js + Tailwind CSS

The application tracks members (Miembros) with automatic role progression based on referral counts.

## Development Commands

### Testing
```bash
# Run all tests (using Pest)
vendor/bin/pest

# Run specific test suite
vendor/bin/pest --filter=MiembroTest

# Alternative using artisan
php artisan test
```

### Asset Building
```bash
# Development mode with hot reload
npm run dev

# Production build
npm run build
```

### Code Quality
```bash
# Format code with Laravel Pint
vendor/bin/pint

# Fix specific file
vendor/bin/pint app/Models/Miembro.php
```

### Database
```bash
# Run migrations
php artisan migrate

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_table_name
```

### Filament
```bash
# Create new Filament resource
php artisan make:filament-resource ModelName

# Create Filament widget
php artisan make:filament-widget WidgetName

# Upgrade Filament assets
php artisan filament:upgrade
```

## Architecture

### Core Domain Model

The application manages a hierarchical member system with automatic role progression:

**Miembro (Member) Roles:**
- **Mariposa Azul**: Entry level (default)
- **Mariposa Padre/Madre**: Achieved when a Mariposa Azul has 10+ direct referrals
- **Mariposa Ejecutiva**: Achieved when a Mariposa Padre/Madre's referrals all have 10+ referrals

**Key Model Relationships:**
- `Miembro` belongs to `Provincia` and `Municipio` (geographic organization)
- `Miembro` has self-referential relationship via `lider_grupo_id` (referral hierarchy)
- `Miembro` belongs to `User` (authentication)
- `User` is auto-created when `Miembro` is created via model events

### Automatic User Creation Pattern

The `Miembro` model uses Laravel's `booted()` method to handle lifecycle events:
- **creating**: Generates random password (format: 3 random chars + 3 digits + special symbol)
- **created**: Auto-creates associated `User` with hashed password
- **updated**: Syncs email/password changes to associated `User`
- **deleting**: Cascades delete to associated `User`

Location: `app/Models/Miembro.php:42-86`

### Observer Pattern for Role Updates

`MiembroObserver` automatically updates a member's leader role when:
- A new member is created
- A member is updated

This triggers the `actualizarRol()` method on the leader, which evaluates role progression/demotion based on referral counts.

Location: `app/Observers/MiembroObserver.php`
Registration: `app/Providers/AppServiceProvider.php:24`

### Authorization via Policies

`MiembroPolicy` enforces hierarchical viewing permissions:
- **Mariposa Azul**: Can only view their direct referrals
- **Mariposa Padre/Madre**: Can view their referrals and their referrals' members
- **Mariposa Ejecutiva**: Can view all members in their hierarchical tree

Used in `MiembroResource::getEloquentQuery()` to filter table results.

Location: `app/Policies/MiembroPolicy.php`

### Filament Admin Panel

**Panel Configuration:**
- Path: `/panel`
- Theme: Custom Vite theme at `resources/css/filament/panel/theme.css`
- Primary color: Red
- Features: Login, password reset, email verification, profile management
- Plugin: Overlook (dashboard widgets)

Location: `app/Providers/Filament/PanelPanelProvider.php`

**Filament Resources Structure:**
- `MiembroResource`: Main member management with reactive provincia/municipio dropdowns
- `ProvinciaResource`: Province management
- `MunicipioResource`: Municipality management (filtered by province)
- `UserResource`: User management

### File Structure

```
app/
├── Filament/
│   ├── Resources/        # CRUD resources
│   └── Widgets/          # Dashboard widgets
├── Models/               # Eloquent models with relationships
├── Observers/            # Model observers for automatic updates
├── Policies/             # Authorization policies
└── Providers/            # Service providers (Observer registration)

database/
├── migrations/           # Database schema
└── seeders/              # Data seeders

resources/
├── css/
│   └── filament/panel/   # Custom Filament theme
└── views/                # Blade templates (mostly Filament overrides)
```

## Important Patterns

### Reactive Filament Forms
Province/Municipality dropdowns use reactive fields - when `provincia_id` changes, `municipio_id` options update automatically.

Example: `app/Filament/Resources/MiembroResource.php:51-68`

### Hierarchical Referral Queries
The `Miembro` model has recursive methods for querying the referral tree:
- `obtenerIdsReferidosDirectos()`: Gets direct referrals
- `obtenerTodosIdsReferidos()`: Recursively gets entire referral tree
- `actualizarRol()`: Evaluates and updates role based on referral structure

### Primary Key Naming
`Miembro` uses non-standard primary key `miembros_id` instead of `id`. Be aware when writing queries or relationships.

## Dependencies

**Key PHP packages:**
- `filament/filament: 3.2.57` - Admin panel framework
- `althinect/filament-spatie-roles-permissions` - Role/permission management
- `awcodes/overlook` - Dashboard overview widgets
- `laravel/framework: ^11.26` - Laravel framework
- `pestphp/pest: ^2.0` - Testing framework

**Frontend:**
- Vite for asset bundling
- TailwindCSS for styling
- Alpine.js (via Filament)
- Livewire 3 for reactive components

## Member Dashboard

### Overview
Modern, professional dashboard for members (`/dashboard`) built with Blade, Livewire, Alpine.js, and Tailwind CSS.

### Routes
- `/dashboard` - Main dashboard with statistics and progress
- `/mis-referidos` - View all direct referrals with filters
- `/mi-perfil` - Member profile view

**Controller:** `app/Http/Controllers/DashboardController.php`

### Features
- **Real-time Statistics**: Referral counts, network size, role distribution
- **Progress Tracking**: Visual progress bars showing advancement to next role
- **Referral Management**: Table view with search and filters
- **Role Visualization**: Color-coded badges and emojis for each role
- **Responsive Design**: Mobile-first design with Tailwind CSS
- **Modern UI**: Gradient backgrounds, smooth transitions, professional cards

### Layout Structure
**Base Layout:** `resources/views/layouts/app.blade.php`
- Gradient navbar with navigation
- User menu with profile and logout
- Mobile-responsive hamburger menu
- Alpine.js for dropdown interactions

**Views:**
- `resources/views/dashboard/index.blade.php` - Main dashboard
- `resources/views/dashboard/referidos.blade.php` - Referrals list
- `resources/views/dashboard/perfil.blade.php` - Profile view

### Design System
**Colors:**
- Primary gradient: Pink-600 → Purple-600 → Blue-600
- Roles:
  - Mariposa Azul: Blue (🦋)
  - Mariposa Padre/Madre: Purple (👑)
  - Mariposa Ejecutiva: Yellow (⭐)

**Components:**
- Gradient stat cards with hover effects
- Animated progress bars
- Avatar initials with gradient backgrounds
- Status badges (active/inactive, roles)

## Configuration Notes

- PHP requirement: ^8.2
- Test environment uses array drivers for cache/session/queue
- Custom password generation creates plain text passwords stored temporarily in `Miembro` model for initial user setup
