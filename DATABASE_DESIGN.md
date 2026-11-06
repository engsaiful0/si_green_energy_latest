# DATABASE DESIGN & ARCHITECTURE
## SI Green Energy - Complete Database Schema

**Date:** November 2, 2026
**Project:** SI Green Energy Laravel CMS
**Database Engine:** MySQL 8.0+ (InnoDB)
**Laravel Version:** 12.70.2

---

## TABLE OF CONTENTS

1. [Database Overview](#database-overview)
2. [User Management Tables](#user-management-tables)
3. [Page Management Tables](#page-management-tables)
4. [Business Content Tables](#business-content-tables)
5. [Blog System Tables](#blog-system-tables)
6. [Team & Testimonials Tables](#team--testimonials-tables)
7. [Communication Tables](#communication-tables)
8. [Settings Tables](#settings-tables)
9. [Media & Activity Tables](#media--activity-tables)
10. [Relationships Diagram](#relationships-diagram)
11. [Indexes & Performance](#indexes--performance)

---

## DATABASE OVERVIEW

### Total Tables: 35
### Relationships: 45+
### Storage Engine: InnoDB
### Character Set: utf8mb4_unicode_ci

### Table Categories
1. **Authentication & Authorization** (4 tables)
2. **Page Management** (5 tables)
3. **Business Content** (15 tables)
4. **Blog System** (4 tables)
5. **Team & Reviews** (3 tables)
6. **Communication** (3 tables)
7. **Configuration** (3 tables)
8. **Media & Logging** (3 tables)

---

## 1. USER MANAGEMENT TABLES

### 1.1 users
**Purpose:** Store user accounts (admin users, editors, authors)

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NULL,
    phone VARCHAR(50) NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    last_login_at TIMESTAMP NULL,
    last_login_ip VARCHAR(45) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,

    INDEX idx_email (email),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Relationships:**
- Has many: blog_posts (as author)
- Has many: activity_logs
- Belongs to many: roles

---

### 1.2 roles
**Purpose:** Define user roles (Super Admin, Admin, Editor, Author)

```sql
CREATE TABLE roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Default Roles:**
- Super Admin
- Admin
- Editor
- Author

---

### 1.3 permissions
**Purpose:** Define granular permissions

```sql
CREATE TABLE permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    module VARCHAR(50) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_module (module),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Permission Modules:**
- dashboard, pages, products, services, projects, blog, team, testimonials, faqs, pricing, contacts, quotes, newsletter, settings, users, media

---

### 1.4 role_user
**Purpose:** Pivot table for user-role relationships

```sql
CREATE TABLE role_user (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_role (user_id, role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 1.5 permission_role
**Purpose:** Pivot table for role-permission relationships

```sql
CREATE TABLE permission_role (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    permission_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,

    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    UNIQUE KEY unique_permission_role (permission_id, role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 2. PAGE MANAGEMENT TABLES

### 2.1 pages
**Purpose:** Store static and dynamic pages

```sql
CREATE TABLE pages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    template VARCHAR(100) NOT NULL DEFAULT 'default',
    content LONGTEXT NULL,
    excerpt TEXT NULL,
    featured_image VARCHAR(255) NULL,
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    meta_keywords VARCHAR(255) NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    order INT UNSIGNED DEFAULT 0,
    views INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,

    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_template (template),
    FULLTEXT idx_search (title, content)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Templates:** home, about, contact, custom

---

### 2.2 page_sections
**Purpose:** Store homepage dynamic sections

```sql
CREATE TABLE page_sections (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_id BIGINT UNSIGNED NULL,
    section_key VARCHAR(100) NOT NULL,
    section_name VARCHAR(255) NOT NULL,
    content JSON NOT NULL,
    is_active BOOLEAN DEFAULT true,
    order INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE,
    INDEX idx_page_id (page_id),
    INDEX idx_section_key (section_key),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Section Keys:**
- hero_slider, features, about, services, cta, why_choose_us, projects, work_process, team, testimonials, brands, blog, footer_cta

---

### 2.3 menus
**Purpose:** Define menu locations

```sql
CREATE TABLE menus (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    location VARCHAR(50) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_location (location)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Locations:** header, footer, sidebar

---

### 2.4 menu_items
**Purpose:** Store individual menu items

```sql
CREATE TABLE menu_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    menu_id BIGINT UNSIGNED NOT NULL,
    parent_id BIGINT UNSIGNED NULL,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(255) NULL,
    page_id BIGINT UNSIGNED NULL,
    type ENUM('page', 'url', 'dropdown') DEFAULT 'page',
    target VARCHAR(20) DEFAULT '_self',
    icon VARCHAR(100) NULL,
    order INT UNSIGNED DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES menu_items(id) ON DELETE CASCADE,
    FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE SET NULL,
    INDEX idx_menu_id (menu_id),
    INDEX idx_parent_id (parent_id),
    INDEX idx_order (order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 2.5 sliders
**Purpose:** Store hero/banner slider items

```sql
CREATE TABLE sliders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255) NULL,
    description TEXT NULL,
    button_text VARCHAR(100) NULL,
    button_link VARCHAR(255) NULL,
    background_image VARCHAR(255) NOT NULL,
    background_image_dark VARCHAR(255) NULL,
    order INT UNSIGNED DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_active (is_active),
    INDEX idx_order (order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 3. BUSINESS CONTENT TABLES

### 3.1 product_categories
**Purpose:** Organize products into categories

```sql
CREATE TABLE product_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    image VARCHAR(255) NULL,
    parent_id BIGINT UNSIGNED NULL,
    order INT UNSIGNED DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (parent_id) REFERENCES product_categories(id) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_parent_id (parent_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.2 products
**Purpose:** Store product information

```sql
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    short_description TEXT NULL,
    description LONGTEXT NULL,
    features JSON NULL,
    specifications JSON NULL,
    price DECIMAL(10,2) NULL,
    featured_image VARCHAR(255) NOT NULL,
    is_featured BOOLEAN DEFAULT false,
    status ENUM('draft', 'published') DEFAULT 'draft',
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    order INT UNSIGNED DEFAULT 0,
    views INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,

    FOREIGN KEY (category_id) REFERENCES product_categories(id) ON DELETE SET NULL,
    INDEX idx_category_id (category_id),
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_featured (is_featured),
    FULLTEXT idx_search (name, short_description, description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.3 product_images
**Purpose:** Store product gallery images

```sql
CREATE TABLE product_images (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) NULL,
    order INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,

    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_id (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.4 service_categories
**Purpose:** Organize services

```sql
CREATE TABLE service_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    icon VARCHAR(255) NULL,
    order INT UNSIGNED DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.5 services
**Purpose:** Store service offerings

```sql
CREATE TABLE services (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    icon VARCHAR(255) NOT NULL,
    short_description TEXT NOT NULL,
    description LONGTEXT NOT NULL,
    benefits JSON NULL,
    process_steps JSON NULL,
    featured_image VARCHAR(255) NOT NULL,
    layout ENUM('full', 'left_sidebar', 'right_sidebar') DEFAULT 'full',
    is_featured BOOLEAN DEFAULT false,
    price_from DECIMAL(10,2) NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    order INT UNSIGNED DEFAULT 0,
    views INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,

    FOREIGN KEY (category_id) REFERENCES service_categories(id) ON DELETE SET NULL,
    INDEX idx_category_id (category_id),
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_featured (is_featured),
    FULLTEXT idx_search (name, short_description, description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.6 service_images
**Purpose:** Service gallery images

```sql
CREATE TABLE service_images (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    service_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) NULL,
    order INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,

    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    INDEX idx_service_id (service_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.7 project_categories
**Purpose:** Categorize projects/portfolios

```sql
CREATE TABLE project_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    color VARCHAR(7) DEFAULT '#3498db',
    order INT UNSIGNED DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.8 project_tags
**Purpose:** Tag projects for filtering

```sql
CREATE TABLE project_tags (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    color VARCHAR(7) DEFAULT '#95a5a6',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.9 projects
**Purpose:** Store portfolio projects

```sql
CREATE TABLE projects (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    client_name VARCHAR(255) NULL,
    project_date DATE NULL,
    location VARCHAR(255) NULL,
    budget DECIMAL(12,2) NULL,
    short_description TEXT NOT NULL,
    description LONGTEXT NOT NULL,
    challenge LONGTEXT NULL,
    solution LONGTEXT NULL,
    results LONGTEXT NULL,
    featured_image VARCHAR(255) NOT NULL,
    video_url VARCHAR(255) NULL,
    website_url VARCHAR(255) NULL,
    is_featured BOOLEAN DEFAULT false,
    status ENUM('draft', 'published') DEFAULT 'draft',
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    views INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,

    FOREIGN KEY (category_id) REFERENCES project_categories(id) ON DELETE SET NULL,
    INDEX idx_category_id (category_id),
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_featured (is_featured),
    FULLTEXT idx_search (name, short_description, description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.10 project_images
**Purpose:** Project gallery images

```sql
CREATE TABLE project_images (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) NULL,
    order INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,

    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    INDEX idx_project_id (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.11 project_tag
**Purpose:** Pivot table for project-tag relationships

```sql
CREATE TABLE project_tag (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    tag_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,

    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES project_tags(id) ON DELETE CASCADE,
    UNIQUE KEY unique_project_tag (project_id, tag_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.12 pricing_plans
**Purpose:** Store pricing/package information

```sql
CREATE TABLE pricing_plans (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    currency VARCHAR(10) DEFAULT 'USD',
    billing_period ENUM('monthly', 'yearly', 'one_time') DEFAULT 'monthly',
    description TEXT NULL,
    features JSON NOT NULL,
    button_text VARCHAR(100) DEFAULT 'Get Started',
    button_link VARCHAR(255) NULL,
    is_popular BOOLEAN DEFAULT false,
    order INT UNSIGNED DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_status (status),
    INDEX idx_popular (is_popular)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.13 faqs
**Purpose:** Frequently asked questions

```sql
CREATE TABLE faqs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NULL,
    question VARCHAR(500) NOT NULL,
    answer LONGTEXT NOT NULL,
    order INT UNSIGNED DEFAULT 0,
    status ENUM('draft', 'published') DEFAULT 'published',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (category_id) REFERENCES faq_categories(id) ON DELETE SET NULL,
    INDEX idx_category_id (category_id),
    INDEX idx_status (status),
    FULLTEXT idx_search (question, answer)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3.14 faq_categories
**Purpose:** FAQ categories

```sql
CREATE TABLE faq_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    order INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 4. BLOG SYSTEM TABLES

### 4.1 blog_categories
**Purpose:** Blog post categories

```sql
CREATE TABLE blog_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    image VARCHAR(255) NULL,
    parent_id BIGINT UNSIGNED NULL,
    order INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (parent_id) REFERENCES blog_categories(id) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_parent_id (parent_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 4.2 blog_tags
**Purpose:** Blog post tags

```sql
CREATE TABLE blog_tags (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    color VARCHAR(7) DEFAULT '#3498db',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 4.3 blog_posts
**Purpose:** Blog articles

```sql
CREATE TABLE blog_posts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    author_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt TEXT NOT NULL,
    content LONGTEXT NOT NULL,
    featured_image VARCHAR(255) NOT NULL,
    layout ENUM('full', 'left_sidebar', 'right_sidebar') DEFAULT 'right_sidebar',
    is_featured BOOLEAN DEFAULT false,
    reading_time INT UNSIGNED NULL,
    status ENUM('draft', 'published', 'scheduled') DEFAULT 'draft',
    publish_date DATETIME NOT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    views INT UNSIGNED DEFAULT 0,
    likes INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,

    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL,
    INDEX idx_author_id (author_id),
    INDEX idx_category_id (category_id),
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_publish_date (publish_date),
    INDEX idx_featured (is_featured),
    FULLTEXT idx_search (title, excerpt, content)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 4.4 blog_post_tag
**Purpose:** Pivot table for blog post-tag relationships

```sql
CREATE TABLE blog_post_tag (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id BIGINT UNSIGNED NOT NULL,
    tag_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,

    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES blog_tags(id) ON DELETE CASCADE,
    UNIQUE KEY unique_post_tag (post_id, tag_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 5. TEAM & TESTIMONIALS TABLES

### 5.1 departments
**Purpose:** Team departments/roles

```sql
CREATE TABLE departments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 5.2 team_members
**Purpose:** Team member profiles

```sql
CREATE TABLE team_members (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    department_id BIGINT UNSIGNED NULL,
    full_name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    position VARCHAR(255) NOT NULL,
    email VARCHAR(255) NULL,
    phone VARCHAR(50) NULL,
    bio LONGTEXT NULL,
    short_bio TEXT NULL,
    photo VARCHAR(255) NOT NULL,
    skills JSON NULL,
    experience_years INT UNSIGNED NULL,
    social_links JSON NULL,
    is_featured BOOLEAN DEFAULT false,
    order INT UNSIGNED DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,

    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL,
    INDEX idx_department_id (department_id),
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_featured (is_featured)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 5.3 testimonials
**Purpose:** Customer testimonials/reviews

```sql
CREATE TABLE testimonials (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(255) NOT NULL,
    position VARCHAR(255) NULL,
    company VARCHAR(255) NULL,
    company_logo VARCHAR(255) NULL,
    rating TINYINT UNSIGNED NOT NULL DEFAULT 5,
    testimonial TEXT NOT NULL,
    avatar VARCHAR(255) NULL,
    is_featured BOOLEAN DEFAULT false,
    status ENUM('pending', 'approved') DEFAULT 'pending',
    order INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_status (status),
    INDEX idx_featured (is_featured),
    INDEX idx_rating (rating)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 5.4 partners
**Purpose:** Partner/client logos

```sql
CREATE TABLE partners (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    logo VARCHAR(255) NOT NULL,
    logo_dark VARCHAR(255) NULL,
    website_url VARCHAR(255) NULL,
    description TEXT NULL,
    is_featured BOOLEAN DEFAULT false,
    order INT UNSIGNED DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_status (status),
    INDEX idx_featured (is_featured)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 6. COMMUNICATION TABLES

### 6.1 contact_messages
**Purpose:** Contact form submissions

```sql
CREATE TABLE contact_messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NULL,
    subject VARCHAR(255) NOT NULL,
    message LONGTEXT NOT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    is_read BOOLEAN DEFAULT false,
    status ENUM('new', 'read', 'replied', 'archived') DEFAULT 'new',
    replied_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_is_read (is_read),
    FULLTEXT idx_search (name, email, subject, message)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 6.2 quote_requests
**Purpose:** Quote request form submissions

```sql
CREATE TABLE quote_requests (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    company VARCHAR(255) NULL,
    service_type VARCHAR(255) NULL,
    project_description LONGTEXT NULL,
    budget_range VARCHAR(100) NULL,
    timeline VARCHAR(100) NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    assigned_to BIGINT UNSIGNED NULL,
    status ENUM('pending', 'processing', 'completed', 'declined') DEFAULT 'pending',
    notes LONGTEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_assigned_to (assigned_to),
    FULLTEXT idx_search (name, email, company, project_description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 6.3 newsletter_subscribers
**Purpose:** Newsletter subscription list

```sql
CREATE TABLE newsletter_subscribers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NULL,
    status ENUM('subscribed', 'unsubscribed') DEFAULT 'subscribed',
    ip_address VARCHAR(45) NULL,
    subscribed_at TIMESTAMP NULL,
    unsubscribed_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_email (email),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 7. SETTINGS TABLES

### 7.1 settings
**Purpose:** Global site settings (key-value pairs)

```sql
CREATE TABLE settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    key VARCHAR(100) NOT NULL UNIQUE,
    value LONGTEXT NULL,
    type VARCHAR(50) DEFAULT 'text',
    group VARCHAR(50) DEFAULT 'general',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_key (key),
    INDEX idx_group (group)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Setting Groups:**
- general, appearance, email, seo, social, contact

---

### 7.2 seo_meta
**Purpose:** SEO metadata for dynamic pages

```sql
CREATE TABLE seo_meta (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    model_type VARCHAR(100) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    meta_keywords VARCHAR(255) NULL,
    og_title VARCHAR(255) NULL,
    og_description TEXT NULL,
    og_image VARCHAR(255) NULL,
    twitter_card VARCHAR(50) DEFAULT 'summary_large_image',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_model (model_type, model_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 8. MEDIA & ACTIVITY TABLES

### 8.1 media
**Purpose:** Media library files

```sql
CREATE TABLE media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    file_size INT UNSIGNED NOT NULL,
    title VARCHAR(255) NULL,
    alt_text VARCHAR(255) NULL,
    caption TEXT NULL,
    folder VARCHAR(255) DEFAULT 'uploads',
    is_dark_variant BOOLEAN DEFAULT false,
    related_media_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (related_media_id) REFERENCES media(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_file_type (file_type),
    INDEX idx_folder (folder),
    FULLTEXT idx_search (file_name, title, alt_text)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 8.2 activity_logs
**Purpose:** Track user activities in admin panel

```sql
CREATE TABLE activity_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    action VARCHAR(100) NOT NULL,
    model_type VARCHAR(100) NULL,
    model_id BIGINT UNSIGNED NULL,
    description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    properties JSON NULL,
    created_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_action (action),
    INDEX idx_model (model_type, model_id),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Actions:** created, updated, deleted, viewed, logged_in, logged_out

---

## 9. RELATIONSHIPS SUMMARY

### One-to-Many Relationships
1. `users` → `blog_posts` (author)
2. `users` → `activity_logs`
3. `pages` → `page_sections`
4. `menus` → `menu_items`
5. `menu_items` → `menu_items` (parent-child)
6. `product_categories` → `products`
7. `products` → `product_images`
8. `service_categories` → `services`
9. `services` → `service_images`
10. `project_categories` → `projects`
11. `projects` → `project_images`
12. `blog_categories` → `blog_posts`
13. `departments` → `team_members`
14. `faq_categories` → `faqs`

### Many-to-Many Relationships
1. `users` ↔ `roles` (via `role_user`)
2. `roles` ↔ `permissions` (via `permission_role`)
3. `projects` ↔ `project_tags` (via `project_tag`)
4. `blog_posts` ↔ `blog_tags` (via `blog_post_tag`)

### Polymorphic Relationships
1. `seo_meta` → Any model (polymorphic)

---

## 10. INDEXES & PERFORMANCE

### Primary Indexes
- All tables have AUTO_INCREMENT primary key `id`

### Foreign Key Indexes
- All foreign keys automatically indexed

### Search Indexes (FULLTEXT)
- `pages`: title, content
- `products`: name, short_description, description
- `services`: name, short_description, description
- `projects`: name, short_description, description
- `blog_posts`: title, excerpt, content
- `faqs`: question, answer
- `contact_messages`: name, email, subject, message
- `quote_requests`: name, email, company, project_description
- `media`: file_name, title, alt_text

### Performance Indexes
- Status fields (for filtering)
- Slug fields (for URL lookups)
- Featured flags (for homepage queries)
- Order fields (for sorting)
- Date fields (for chronological queries)

---

## 11. DATA SEEDING PLAN

### Required Seeders
1. **RolesSeeder** - 4 default roles
2. **PermissionsSeeder** - ~50 permissions
3. **UsersSeeder** - 1 super admin
4. **MenusSeeder** - Header, footer, sidebar menus
5. **SettingsSeeder** - Default site settings
6. **PagesSeeder** - Home, About, Contact pages

### Optional Demo Data Seeders
7. **ProductsSeeder** - 10 demo products
8. **ServicesSeeder** - 8 demo services
9. **ProjectsSeeder** - 12 demo projects
10. **BlogPostsSeeder** - 15 demo posts
11. **TeamMembersSeeder** - 8 team members
12. **TestimonialsSeeder** - 6 testimonials
13. **PartnersSeeder** - 8 partner logos
14. **FAQsSeeder** - 10 FAQs
15. **PricingPlansSeeder** - 3 pricing plans

---

## 12. MIGRATION ORDER

**Phase 3 Migration Order (To prevent foreign key errors):**

1. Users & Auth (migrations 1-5)
2. Pages & Menus (migrations 6-10)
3. Categories (migrations 11-17)
4. Main Content (migrations 18-30)
5. Communication (migrations 31-33)
6. Settings & Media (migrations 34-35)

---

## SUMMARY

**Total Tables:** 35
**Total Relationships:** 45+
**Total Indexes:** 100+
**Database Size Estimate:** 50-100MB (with demo data)

**Status:** ✅ Database Design Complete
**Next Step:** Phase 2 - Foundation Setup & Asset Integration

---

**Document Version:** 1.0
**Last Updated:** November 2, 2026
