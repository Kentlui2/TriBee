# ecomerce-bsit3b_ProjectPlan

# 🛒 Laravel E-Commerce System — Class Project Plan

> **Read this before writing a single line of code.**
> This document is the single source of truth for all 5 groups.
> Every group leader is responsible for making sure their members follow this.

---

## 📋 Table of Contents

1. [Project Overview](#1-project-overview)
2. [Group Assignments & Boundaries](#2-group-assignments--boundaries)
3. [Shared Standards — Agree Before Coding](#3-shared-standards--agree-before-coding)
4. [Folder Structure](#4-folder-structure)
5. [Database & ERD](#5-database--erd)
6. [API Contracts Between Groups](#6-api-contracts-between-groups)
7. [Git Strategy](#7-git-strategy)
8. [Milestone & Timeline](#8-milestone--timeline)
9. [Do's and Don'ts](#9-dos-and-donts)
10. [Communication Rules](#10-communication-rules)
11. [Group Leader Responsibilities](#11-group-leader-responsibilities)

---

## 1. Project Overview

We are building a **full Laravel E-Commerce System** as a class, split across 5 groups. Each group owns one module of the system. The app must work as one connected platform — not 5 separate apps.

### Tech Stack (everyone must use the same)

| Item | Choice |
|---|---|
| Framework | Laravel 11 |
| PHP Version | PHP 8.2+ |
| Database | MySQL |
| Authentication | Laravel Breeze + Sanctum |
| Frontend | Blade Templates + Tailwind CSS |
| Version Control | Git (one shared repo) |
| Local Dev | Laravel Herd or XAMPP |

### The 5 Modules

| Group | Module |
|---|---|
| G1 | User Account & Authentication |
| G2 | Product Catalog & Inventory |
| G3 | Shopping Cart & Pricing Engine |
| G4 | Order Management & Checkout |
| G5 | Payment & Shipping Integration |

---

## 2. Group Assignments & Boundaries

### G1 — User Account & Authentication

**Owns:**
- `app/Modules/Auth/`
- `users` table, `roles` table
- `IsAdmin.php` and `Authenticate.php` middleware
- `resources/views/auth/`

**Responsible for delivering to all groups:**
- Working login/registration/logout
- `auth()->user()` — authenticated user object
- `user_id` on all protected routes
- Role middleware: `IsAdmin` for admin-only routes

**Must finish first.** Every other group depends on auth.

---

### G2 — Product Catalog & Inventory

**Owns:**
- `app/Modules/Products/`
- `products`, `categories`, `inventory` tables
- `resources/views/products/`

**Depends on:** G1 (admin auth for CRUD)

**Delivers to G3 & G4:**
- Product data: `id`, `name`, `price`, `stock`, `category_id`
- `InventoryService::decrementStock($productId, $qty)` — G4 will call this
- `InventoryService::checkStock($productId, $qty)` — G3 will call this

---

### G3 — Shopping Cart & Pricing Engine

**Owns:**
- `app/Modules/Cart/`
- `carts`, `cart_items` tables
- `PricingEngine.php` — discount and tax logic
- `resources/views/cart/`

**Depends on:** G1 (user), G2 (product data and stock check)

**Delivers to G4:**
- `CartService::getCartTotal($userId)` — finalized cart with total price
- `CartService::getCartItems($userId)` — list of items with quantities

---

### G4 — Order Management & Checkout

**Owns:**
- `app/Modules/Orders/`
- `orders`, `order_items` tables
- `resources/views/orders/`

**Depends on:** G1 (user), G2 (stock decrement), G3 (cart total and items)

**Delivers to G5:**
- `OrderService::getOrderTotal($orderId)` — total amount for payment
- Order object: `id`, `user_id`, `total`, `status`

---

### G5 — Payment & Shipping Integration

**Owns:**
- `app/Modules/Payment/`
- `payments`, `shipments` tables
- `resources/views/payment/`

**Depends on:** G4 (order), G1 (user address)

**Delivers back to G4:**
- `PaymentService::getPaymentStatus($orderId)` — to update order status after payment

---

## 3. Shared Standards — Agree Before Coding

> These must be agreed on by ALL group leaders in the first meeting. No exceptions.

### Naming Conventions

```
Database tables:     snake_case, plural       → users, order_items, cart_items
Columns:             snake_case               → first_name, created_at, product_id
Models:              PascalCase, singular     → User, OrderItem, CartItem
Controllers:         PascalCase + suffix      → ProductController, CartController
Services:            PascalCase + suffix      → CartService, InventoryService
Routes:              kebab-case               → /cart-items, /order-history
Blade views:         kebab-case              → product-list.blade.php
```

### PHP Code Standards

- Always use `strict_types=1` at the top of every PHP file
- No business logic inside Controllers — put it in Services
- Type-hint everything: `function addItem(int $userId, int $productId): Cart`
- No raw SQL — use Eloquent ORM only
- All models must have `$fillable` defined

### Blade / Frontend Standards

- All views extend `layouts.app` (shared layout — G1 sets this up)
- Use Tailwind CSS classes only — no custom CSS unless necessary
- No inline JavaScript — use `@push('scripts')` to a shared stack
- All forms must have `@csrf`

---

## 4. Folder Structure

```
ecommerce-app/
│
├── app/
│   ├── Modules/                        ← each group works here ONLY
│   │   ├── Auth/                       [G1]
│   │   │   ├── Controllers/
│   │   │   │   ├── AuthController.php
│   │   │   │   └── ProfileController.php
│   │   │   ├── Models/
│   │   │   │   ├── User.php
│   │   │   │   └── Role.php
│   │   │   ├── Services/
│   │   │   │   └── AuthService.php
│   │   │   └── routes.php
│   │   │
│   │   ├── Products/                   [G2]
│   │   │   ├── Controllers/
│   │   │   │   ├── ProductController.php
│   │   │   │   └── CategoryController.php
│   │   │   ├── Models/
│   │   │   │   ├── Product.php
│   │   │   │   ├── Category.php
│   │   │   │   └── Inventory.php
│   │   │   ├── Services/
│   │   │   │   ├── ProductService.php
│   │   │   │   └── InventoryService.php
│   │   │   └── routes.php
│   │   │
│   │   ├── Cart/                       [G3]
│   │   │   ├── Controllers/
│   │   │   │   └── CartController.php
│   │   │   ├── Models/
│   │   │   │   ├── Cart.php
│   │   │   │   └── CartItem.php
│   │   │   ├── Services/
│   │   │   │   ├── CartService.php
│   │   │   │   └── PricingEngine.php
│   │   │   └── routes.php
│   │   │
│   │   ├── Orders/                     [G4]
│   │   │   ├── Controllers/
│   │   │   │   ├── OrderController.php
│   │   │   │   └── CheckoutController.php
│   │   │   ├── Models/
│   │   │   │   ├── Order.php
│   │   │   │   └── OrderItem.php
│   │   │   ├── Services/
│   │   │   │   ├── OrderService.php
│   │   │   │   └── CheckoutService.php
│   │   │   └── routes.php
│   │   │
│   │   └── Payment/                    [G5]
│   │       ├── Controllers/
│   │       │   ├── PaymentController.php
│   │       │   └── ShippingController.php
│   │       ├── Models/
│   │       │   ├── Payment.php
│   │       │   └── Shipment.php
│   │       ├── Services/
│   │       │   ├── PaymentService.php
│   │       │   └── ShippingService.php
│   │       └── routes.php
│   │
│   └── Http/
│       └── Middleware/
│           ├── IsAdmin.php             [G1 owns]
│           └── Authenticate.php        [G1 owns]
│
├── database/
│   ├── migrations/                     ← each group adds their own files
│   │   ├── ..._create_users_table.php              [G1]
│   │   ├── ..._create_products_table.php           [G2]
│   │   ├── ..._create_categories_table.php         [G2]
│   │   ├── ..._create_inventory_table.php          [G2]
│   │   ├── ..._create_carts_table.php              [G3]
│   │   ├── ..._create_cart_items_table.php         [G3]
│   │   ├── ..._create_orders_table.php             [G4]
│   │   ├── ..._create_order_items_table.php        [G4]
│   │   ├── ..._create_payments_table.php           [G5]
│   │   └── ..._create_shipments_table.php          [G5]
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php          [shared]
│       ├── UserSeeder.php              [G1]
│       └── ProductSeeder.php           [G2]
│
├── resources/
│   └── views/
│       ├── layouts/                    ← SHARED — coordinate before editing
│       │   └── app.blade.php
│       ├── auth/                       [G1]
│       ├── products/                   [G2]
│       ├── cart/                       [G3]
│       ├── orders/                     [G4]
│       └── payment/                    [G5]
│
├── routes/
│   ├── web.php                         ← loads all module routes (shared)
│   └── api.php
│
├── docs/                               ← shared planning documents
│   ├── ERD.png
│   ├── API_CONTRACTS.md
│   └── CONVENTIONS.md
│
├── .env
├── composer.json
└── README.md
```

### How `routes/web.php` works

Each group has their own `routes.php` inside their module. The main `web.php` just loads all of them:

```php
<?php
// routes/web.php

require base_path('app/Modules/Auth/routes.php');
require base_path('app/Modules/Products/routes.php');
require base_path('app/Modules/Cart/routes.php');
require base_path('app/Modules/Orders/routes.php');
require base_path('app/Modules/Payment/routes.php');
```

---

## 5. Database & ERD

### Table Ownership

| Table | Owner | Key Foreign Keys |
|---|---|---|
| `users` | G1 | — |
| `roles` | G1 | — |
| `categories` | G2 | — |
| `products` | G2 | `category_id → categories.id` |
| `inventory` | G2 | `product_id → products.id` |
| `carts` | G3 | `user_id → users.id` |
| `cart_items` | G3 | `cart_id → carts.id`, `product_id → products.id` |
| `orders` | G4 | `user_id → users.id` |
| `order_items` | G4 | `order_id → orders.id`, `product_id → products.id` |
| `payments` | G5 | `order_id → orders.id` |
| `shipments` | G5 | `order_id → orders.id` |

### Core Table Schemas (minimum required columns)

```sql
-- G1
users:       id, name, email, password, role, timestamps
roles:       id, name, timestamps

-- G2
categories:  id, name, description, timestamps
products:    id, name, description, price, category_id, image, timestamps
inventory:   id, product_id, stock, timestamps

-- G3
carts:       id, user_id, timestamps
cart_items:  id, cart_id, product_id, quantity, timestamps

-- G4
orders:      id, user_id, total, status, timestamps
             status ENUM: pending, processing, shipped, delivered, cancelled
order_items: id, order_id, product_id, quantity, price, timestamps

-- G5
payments:    id, order_id, method, amount, status, reference_no, timestamps
             status ENUM: pending, paid, failed, refunded
shipments:   id, order_id, address, courier, tracking_no, status, timestamps
             status ENUM: pending, shipped, delivered
```

> **RULE:** Any changes to a shared table column must be announced to all leaders BEFORE committing.

---

## 6. API Contracts Between Groups

This defines what each group exposes to other groups. Treat these as contracts — do not change without announcing it.

### G2 exposes to G3 and G4

```php
// InventoryService.php
public function checkStock(int $productId, int $qty): bool
public function decrementStock(int $productId, int $qty): void

// ProductService.php
public function getProduct(int $productId): Product
// Returns: id, name, price, stock, category_id
```

### G3 exposes to G4

```php
// CartService.php
public function getCartItems(int $userId): Collection
// Returns: Collection of { product_id, quantity, unit_price, subtotal }

public function getCartTotal(int $userId): float
// Returns: total price as float

public function clearCart(int $userId): void
// G4 calls this after order is placed
```

### G4 exposes to G5

```php
// OrderService.php
public function getOrder(int $orderId): Order
// Returns: id, user_id, total, status, order_items

public function updateOrderStatus(int $orderId, string $status): void
// G5 calls this after payment is confirmed
```

### G1 exposes to everyone

```php
// Via Laravel middleware — just use it in routes:
Route::middleware(['auth'])->group(function () { ... });
Route::middleware(['auth', 'isAdmin'])->group(function () { ... });

// In any controller, get current user:
$user = auth()->user();
$userId = auth()->id();
```

---

## 7. Git Strategy

### Branching Rules

```
main        → stable, working code only. NO direct pushes.
dev         → integration branch. All groups merge here.
g1/feature  → G1's working branches (e.g. g1/login-page)
g2/feature  → G2's working branches
g3/feature  → G3's working branches
g4/feature  → G4's working branches
g5/feature  → G5's working branches
```

### Workflow (every group follows this)

```bash
# 1. Always start from dev
git checkout dev
git pull origin dev

# 2. Create your feature branch
git checkout -b g2/product-crud

# 3. Work on your feature, commit often
git add .
git commit -m "G2: add ProductController with index and show"

# 4. Push your branch
git push origin g2/product-crud

# 5. Create a Pull Request to dev — NOT to main
# Ask your group leader to review before merging
```

### Commit Message Format

```
G[number]: short description of what you did

Examples:
G1: add login and registration pages
G2: create Product model and migration
G3: implement CartService addItem method
G4: fix order status update bug
G5: integrate PayMongo sandbox payment
```

### Rules

- **Never push directly to `main` or `dev`**
- **Never edit another group's files**
- Always `git pull origin dev` before starting new work
- If you get a merge conflict in a file you don't own — stop and ask the owner to resolve it

---

## 8. Milestone & Timeline

| Week | Milestone | Who |
|---|---|---|
| **Week 1** | Leaders meeting, agree on ERD, set up Git repo, lock tech stack | All leaders |
| **Week 1** | Laravel project scaffolded, folder structure created, `.env` shared | G1 (leads setup) |
| **Week 2** | Auth complete: register, login, logout, roles, middleware | G1 |
| **Week 2** | All groups scaffold their migrations and models | All groups |
| **Week 3** | Product CRUD (admin), category management, inventory tracking | G2 |
| **Week 3** | Cart: add/remove/update items, PricingEngine working | G3 starts |
| **Week 4** | Cart done, checkout flow starts, payment sandbox setup | G3 done, G4 + G5 starts |
| **Week 4** | Order creation from cart, order history page | G4 |
| **Week 5** | Payment integration, shipping computation, order status update | G5 |
| **Week 5** | **Integration week** — all modules connected and tested together | All groups |
| **Week 6** | Bug fixing, UI polish, demo preparation | All groups |

> **Week 5 integration is the most critical week.** This is where everything either works together or falls apart. Don't wait until then to discover your module doesn't connect.

---

## 9. Do's and Don'ts

### ✅ DO's

- **DO** read this document fully before starting
- **DO** attend every leader sync meeting
- **DO** communicate blockers early — if G3 is waiting on G2, say so immediately
- **DO** write your migrations before writing your controllers
- **DO** seed your own table with test data so other groups can test against it
- **DO** use `dd()` or `tinker` to debug, not `var_dump`
- **DO** keep your routes organized inside your own `routes.php`
- **DO** put logic in Service classes, not Controllers
- **DO** test your own module completely before saying it's done
- **DO** announce any schema changes to all leaders first
- **DO** name your commits properly (see Git Strategy section)
- **DO** pull from `dev` before starting any new work
- **DO** ask for help early — don't stay stuck for hours silently

---

### ❌ DON'Ts

- **DON'T** edit files inside another group's `Modules/` folder
- **DON'T** push directly to `main` or `dev`
- **DON'T** change a shared table's columns without announcing it
- **DON'T** put business logic inside Controllers
- **DON'T** use raw SQL queries — use Eloquent
- **DON'T** create new tables without telling all leaders
- **DON'T** use `public $guarded = []` — always define `$fillable` explicitly
- **DON'T** hardcode user IDs or product IDs in your code
- **DON'T** wait until Week 5 to test if your module connects with others
- **DON'T** copy-paste code from the internet without understanding it
- **DON'T** skip migrations — never edit the database manually through phpMyAdmin
- **DON'T** commit your `.env` file to Git — it contains secrets
- **DON'T** break the `layouts/app.blade.php` without telling everyone
- **DON'T** rename or delete a Service method without telling the groups that depend on it

---

## 10. Communication Rules

### Group Leader Sync

- All **5 leaders have a group chat** — this is for coordination, not casual talk
- Leaders sync **every 2–3 days minimum** — share: done, in-progress, blocked
- If your group is **blocked** (waiting on another group), say so immediately

### Weekly Status Report (leaders post this every Friday)

```
Group [number] — Week [number] Update
✅ Done this week:
🔄 In progress:
🚫 Blocked by:
📅 Plan for next week:
```

### Shared Documents

All leaders must have edit access to:

- `docs/ERD.png` — finalized entity relationship diagram
- `docs/API_CONTRACTS.md` — what each group exposes
- `docs/CONVENTIONS.md` — naming and code standards
- This file: `README.md` — the master plan

### Before Changing Anything Shared

If you need to change something that affects another group (table column, service method name, shared view), you must:

1. Post in the leaders chat what you want to change and why
2. Wait for acknowledgment from affected groups
3. Then make the change and announce when it's done

---

## 11. Group Leader Responsibilities

As a group leader, your job is **not just to code** — it's to manage.

### Your duties:

- Make sure your members **know their tasks** and deadlines
- Be the **point of contact** for other groups when they need your module
- **Review your members' code** before it gets merged
- Raise blockers **early** — don't wait
- Attend all **leader sync meetings**
- Keep your section of the **docs updated**
- Make sure your group **doesn't touch other groups' files**
- If a member is stuck, **help them or escalate**

### Before you say your module is done, check:

- [ ] All migrations run without errors (`php artisan migrate`)
- [ ] All seeders work (`php artisan db:seed`)
- [ ] All routes are accessible and return the right views
- [ ] Your Service methods work as documented in API Contracts
- [ ] Another group has tested against your module (not just you)
- [ ] No hardcoded IDs or test data left in production code
- [ ] Code is committed and merged to `dev`

---

## Quick Reference — Who To Ask

| I need... | Ask... |
|---|---|
| Login / auth not working | G1 |
| Product data / stock info | G2 |
| Cart total / cart items | G3 |
| Order creation / checkout | G4 |
| Payment status / shipping | G5 |
| Shared layout is broken | All leaders — coordinate |
| Git conflict in my files | Resolve it yourself |
| Git conflict in someone else's files | Ask the owner to fix it |

---

*Last updated: Week 1 — update this document as the project evolves.*
*All group leaders must sign off that they have read this document.*

| Group | Leader Name | Confirmed |
|---|---|---|
| G1 | | ☐ |
| G2 | | ☐ |
| G3 | | ☐ |
| G4 | | ☐ |
| G5 | | ☐ |
