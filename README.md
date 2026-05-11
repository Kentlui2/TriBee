# 🛒 Laravel E-Commerce System — Class Project Plan

> **Read this before writing a single line of code.**
> This document is the single source of truth for all 5 groups.
> Every group leader is responsible for making sure their members follow this.

---

## 📋 Table of Contents

1. [How to Start](#1-how-to-start)
2. [Group Assignments & Boundaries](#2-group-assignments--boundaries)
3. [Shared Standards — Agree Before Coding](#3-shared-standards--agree-before-coding)
4. [Folder Structure](#4-folder-structure)
5. [Database & ERD](#5-database--erd)
6. [API Contracts Between Groups](#6-api-contracts-between-groups)
7. [Setup & Installation Guide](#7-setup--installation-guide)
8. [Git Strategy & Essential Commands](#8-git-strategy--essential-commands)
9. [Milestone & Timeline](#9-milestone--timeline)
10. [Do's and Don'ts](#10-dos-and-donts)
11. [Communication Rules](#11-communication-rules)
12. [Group Leader Responsibilities](#12-group-leader-responsibilities)

---

## Project Overview

We are building a **full Laravel E-Commerce System** as a class, split across 5 groups. Each group owns one module of the system. The app must work as one connected platform — not 5 separate apps.

### Tech Stack (everyone must use the same)

| Item | Choice | **if missing/wrong version**
|---|---|---|
| Framework | Laravel 13 | `composer update` |
| PHP Version | PHP 8.5 | `winget update PHP.PHP.8.5` |
| Database | MySQL | |
| Authentication | Laravel Breeze + Sanctum | |
| Frontend | Blade Templates + Tailwind CSS | |
| Version Control | Git (one shared repo) | |
| Local Dev | Laravel Herd or XAMPP | |

### The 5 Modules

| Group | Module |
|---|---|
| G1 | User Account & Authentication |
| G2 | Product Catalog & Inventory |
| G3 | Shopping Cart & Pricing Engine |
| G4 | Order Management & Checkout |
| G5 | Payment & Shipping Integration |

---

## 1. How To Start

***Every member must complete this setup before writing code.***

### Step 1 — Clone the Repository
`git clone https://github.com/dmaasin24/ecomerce-bsit3b.git`
### Step 2 — Go Into the Project Folder
`cd ecomerce-bsit3b`
### Step 3 — Fetch Your Assigned Branch

**Replace BRANCH_NAME with your actual assigned branch.**

| Group | Branch |
|---|---|
| G1 | `G1---User-Authentication` |
| G2 | `G2---Product-Catalog-&-Inventory`|
| G3 | `G3---Shopping-Cart-&-Pricing-Engine` |
| G4 | `G4---Order-Management-&-Checkout` |
| G5 | `G5---Payment-&-Shipping` |

*Example:*

`git fetch origin G3---Shopping-Cart-&-Pricing-Engine`

### Step 4 — Switch To Your Branch
`git switch -c "BRANCH_NAME" origin/"BRANCH_NAME"`

*Example:*

git switch -c "G3---Shopping-Cart-&-Pricing-Engine" origin/"G3---Shopping-Cart-&-Pricing-Engine"

Quotes are required because branch names contain special characters like &.

### Step 5 — Install Backend Dependencies
`composer install`

*This installs:*
- Laravel
- Breeze
- Sanctum
- All PHP packages

### Step 6 — Install Frontend Dependencies
`npm install`

This installs:

- Tailwind CSS
- Vite
- Frontend tooling

### Step 7 — Configure Environment File

`cp .env.example .env`

**Generate the Laravel application key:**

`php artisan key:generate`

### Step 8 — Configure Database
**Open .env and update:**

`DB_CONNECTION=mysql`

`DB_HOST=127.0.0.1`

`DB_PORT=3306`

`DB_DATABASE=ecommerce_db`

`DB_USERNAME=root`

`DB_PASSWORD=`


### Step 9 — Run Migrations
`php artisan migrate`

*Optional: seed sample data*

`php artisan db:seed`

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

## 7. Setup & Installation Guide

> Every member of every group must complete this before the first coding session.

### Step 1 — Install Required Software

Install all of these on your machine. Click the links or search for them.

| Software | Purpose | Download |
|---|---|---|
| **PHP 8.2+** | Run Laravel | https://www.php.net/downloads |
| **Composer** | PHP package manager | https://getcomposer.org |
| **Node.js (LTS)** | Frontend assets (Tailwind) | https://nodejs.org |
| **Git** | Version control | https://git-scm.com |
| **MySQL** | Database | comes with XAMPP |
| **XAMPP** | Local server (Apache + MySQL) | https://www.apachefriends.org |
| **VS Code** | Code editor (recommended) | https://code.visualstudio.com |

> **Windows users:** After installing PHP, make sure to add it to your system PATH so you can run `php` in the terminal.

### Step 2 — Verify Your Installs

Open your terminal (Command Prompt, PowerShell, or Git Bash) and run these. Each should print a version number — if it says "command not found", the install didn't work.

```bash
php --version
# Expected: PHP 8.2.x or higher

composer --version
# Expected: Composer version 2.x.x

node --version
# Expected: v20.x.x or higher

npm --version
# Expected: 10.x.x or higher

git --version
# Expected: git version 2.x.x
```

### Step 3 — Configure Git Identity (first time only)

Every member must do this once. This is what shows up on your commits so the team knows who did what.

```bash
git config --global user.name "Your Full Name"
git config --global user.email "your@email.com"

# Verify it saved
git config --global --list
```

### Step 4 — Clone the Project Repo

The repo link will be shared by the group leader who sets it up (G1). Once you have it:

```bash
# Clone the repo to your machine
git clone https://github.com/your-class/ecommerce-app.git

# Go into the project folder
cd ecommerce-app
```

### Step 5 — Install Project Dependencies

```bash
# Install PHP packages (Laravel and all libraries)
composer install

# Install frontend packages (Tailwind, Vite, etc.)
npm install
```

### Step 6 — Set Up Your Environment File

```bash
# Copy the example env file
cp .env.example .env

# Generate the app key (required for Laravel to work)
php artisan key:generate
```

Then open `.env` in VS Code and update your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_db
DB_USERNAME=root
DB_PASSWORD=
```

> **Note:** `DB_PASSWORD` is blank by default in XAMPP. If you set a password, put it here.

### Step 7 — Set Up the Database

1. Open XAMPP and start **Apache** and **MySQL**
2. Go to `http://localhost/phpmyadmin`
3. Create a new database named `ecommerce_db`
4. Then run migrations:

```bash
# Run all migrations (creates all tables)
php artisan migrate

# Run seeders (fills tables with test data)
php artisan db:seed
```

### Step 8 — Run the App

You need two terminals open at the same time:

```bash
# Terminal 1 — starts the Laravel server
php artisan serve
# Visit: http://localhost:8000

# Terminal 2 — compiles Tailwind CSS (keep this running while working)
npm run dev
```

### VS Code Extensions (Recommended)

Install these from the VS Code Extensions panel (`Ctrl+Shift+X`):

| Extension | Why |
|---|---|
| **PHP Intelephense** | PHP autocomplete and error detection |
| **Laravel Blade Snippets** | Blade template helpers |
| **Tailwind CSS IntelliSense** | Tailwind class autocomplete |
| **GitLens** | See who wrote what line in Git |
| **Prettier** | Auto-formats your code on save |
| **PHP CS Fixer** | Enforces PHP code style |

---

## 8. Git Strategy & Essential Commands

### Branching Rules

```
main        → stable, working code only. NO direct pushes ever.
dev         → integration branch. All groups merge here.
g1/feature  → G1's working branches (e.g. g1/login-page)
g2/feature  → G2's working branches
g3/feature  → G3's working branches
g4/feature  → G4's working branches
g5/feature  → G5's working branches
```

---

### Daily Workflow (every member follows this every day)

```bash
# 1. Always start by pulling the latest changes from dev
git checkout dev
git pull origin dev

# 2. Switch to your group's branch (or create one if new feature)
git checkout g2/product-crud
# OR create a new branch:
git checkout -b g2/inventory-service

# 3. Write your code, then stage your changes
git add .                        # stage everything
git add app/Modules/Products/    # OR stage only your folder (safer)

# 4. Commit with a proper message
git commit -m "G2: add InventoryService checkStock method"

# 5. Push your branch to GitHub
git push origin g2/inventory-service

# 6. Go to GitHub → open a Pull Request → set target branch to dev
# Tag your group leader to review
```

---

### Essential Git Commands Reference

#### Checking Status

```bash
git status
# Shows which files are modified, staged, or untracked

git log --oneline
# Shows recent commits in a compact list

git log --oneline --graph --all
# Shows all branches visually — great for seeing what everyone is doing

git diff
# Shows what changed in your files before staging
```

#### Branching

```bash
git branch
# Lists all local branches (* = current branch)

git branch -a
# Lists all branches including remote ones

git checkout dev
# Switch to the dev branch

git checkout -b g3/pricing-engine
# Create a new branch AND switch to it

git branch -d g3/old-feature
# Delete a branch (only after it's merged)
```

#### Syncing with Remote

```bash
git fetch origin
# Downloads latest changes WITHOUT merging — safe to run anytime

git pull origin dev
# Downloads AND merges latest dev into your current branch

git push origin g2/product-crud
# Uploads your branch to GitHub

git push --set-upstream origin g2/new-feature
# First push of a brand new branch
```

#### Staging & Committing

```bash
git add .
# Stage all changes in the current folder

git add app/Modules/Products/
# Stage only your module's folder (recommended — avoids accidents)

git add -p
# Stage changes chunk by chunk — review before committing

git commit -m "G2: create Product model with fillable fields"
# Commit with a message

git commit --amend -m "G2: fix typo in commit message"
# Fix your LAST commit message (only before pushing)

git reset HEAD~1
# Undo your last commit but KEEP the file changes (soft undo)
```

#### Handling Merge Conflicts

A merge conflict happens when two people edited the same file. Git will mark the conflict inside the file like this:

```
<<<<<<< HEAD
Your version of the code
=======
Their version of the code
>>>>>>> dev
```

To resolve it:

```bash
# Step 1 — pull the latest dev
git pull origin dev

# Step 2 — open the conflicting file in VS Code
# Manually pick which version to keep (or combine both)
# Delete the <<<, ===, >>> markers completely

# Step 3 — after fixing, stage and commit
git add .
git commit -m "G2: resolve merge conflict in ProductController"
```

> **Rule:** If the conflict is in a file you don't own — stop. Tell the file's owner to resolve it.

#### Undoing Mistakes

```bash
git checkout -- filename.php
# Discard ALL changes to a file (goes back to last commit)
# ⚠️ This is permanent — use carefully

git stash
# Temporarily hide your uncommitted changes (useful when switching branches)

git stash pop
# Bring back your stashed changes

git revert abc1234
# Create a new commit that undoes a specific commit (safe — keeps history)
```

#### Useful Shortcuts

```bash
git pull origin dev && git checkout -b g4/checkout-flow
# Pull latest then immediately create a new branch in one line

git log --oneline -10
# See only the last 10 commits

git show abc1234
# See the full details of a specific commit

git blame filename.php
# See who wrote each line of a file (great for finding who to ask)
```

---

### Commit Message Format

```
G[number]: short description of what you did

✅ Good examples:
G1: add login and registration pages
G2: create Product model and migration
G3: implement CartService addItem method
G4: fix order status update bug
G5: integrate PayMongo sandbox payment

❌ Bad examples:
fixed stuff
wip
asdfjkl
G2: changes
```

---

### Git Rules Summary

- **Never push directly to `main` or `dev`** — always use a branch + Pull Request
- **Never edit another group's files** — stay inside your `Modules/` folder
- **Always pull from `dev` before starting new work** — avoid outdated code
- **Commit often, push daily** — don't sit on 3 days of uncommitted work
- **If you get a conflict in someone else's file** — stop and ask them to fix it
- **Never force push** (`git push --force`) — it can delete other people's work

---

## 9. Milestone & Timeline

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

## 10. Do's and Don'ts

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

## 11. Communication Rules

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

## 12. Group Leader Responsibilities

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
