# CMS FEATURE MAPPING
## SI Green Energy - Complete Content Management System Requirements

**Date:** November 2, 2026
**Project:** SI Green Energy Laravel CMS
**Template:** Slaze - Solar & Renewable Energy

---

## TABLE OF CONTENTS

1. [Admin Dashboard Overview](#1-admin-dashboard-overview)
2. [Website CMS Modules](#2-website-cms-modules)
3. [Business Management Modules](#3-business-management-modules)
4. [Content Management Modules](#4-content-management-modules)
5. [Settings & Configuration](#5-settings--configuration)
6. [User & Permission Management](#6-user--permission-management)
7. [Forms & Communication](#7-forms--communication)
8. [Media Management](#8-media-management)
9. [SEO Management](#9-seo-management)
10. [Activity Logging](#10-activity-logging)

---

## 1. ADMIN DASHBOARD OVERVIEW

### Main Dashboard Page
**Route:** `/admin/dashboard`

#### Dashboard Widgets (Real-time Statistics)

**Content Statistics (4 Cards)**
- Total Products (count + trend)
- Total Services (count + trend)
- Total Projects (count + trend)
- Total Blog Posts (count + trend)

**Business Statistics (4 Cards)**
- Quote Requests (this month)
- Contact Messages (unread count)
- Newsletter Subscribers (total)
- Team Members (active)

**Charts & Graphs**
1. **Monthly Enquiry Chart** (Line chart)
   - Quote requests per month (last 6 months)
   - Contact messages per month

2. **Content Distribution** (Pie chart)
   - Services by category
   - Projects by category
   - Blog posts by category

3. **Popular Services** (Bar chart)
   - Most viewed services (top 5)

4. **Recent Activity Timeline**
   - Latest 10 activities
   - User, action, timestamp
   - Color-coded by action type

**Quick Actions Panel**
- Create New Product
- Create New Service
- Create New Project
- Create New Blog Post
- View Quote Requests
- View Contact Messages

**Recent Content Tables**
1. Recent Blog Posts (5 latest) - Title, Date, Status, Views
2. Recent Quote Requests (5 latest) - Name, Service, Date, Status
3. Recent Contact Messages (5 latest) - Name, Subject, Date, Status

---

## 2. WEBSITE CMS MODULES

### 2.1 Pages Management
**Route:** `/admin/pages`

#### Features
- ✅ List all pages
- ✅ Create new page
- ✅ Edit existing page
- ✅ Delete page
- ✅ Duplicate page
- ✅ Page visibility toggle (published/draft)
- ✅ Set page template (homepage, about, contact, custom)

#### Page Fields
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| Title | Text | Yes | Page title |
| Slug | Text | Yes | URL slug (auto-generated) |
| Template | Select | Yes | Page template type |
| Meta Title | Text | No | SEO title |
| Meta Description | Textarea | No | SEO description |
| Meta Keywords | Text | No | SEO keywords |
| Featured Image | Media | No | Page header image |
| Content | WYSIWYG | No | Page content |
| Status | Select | Yes | Draft/Published |
| Order | Number | No | Sort order |
| Created At | Timestamp | Auto | |
| Updated At | Timestamp | Auto | |

#### Page Templates Available
1. Home Page (4 variations: index, index-2, index-two, index-three)
2. About Page
3. Contact Page (2 variations)
4. Custom Page

---

### 2.2 Homepage Sections Manager
**Route:** `/admin/homepage-sections`

#### Sections Management
- ✅ View all sections
- ✅ Enable/disable sections
- ✅ Reorder sections (drag & drop)
- ✅ Edit section content
- ✅ Configure section settings

#### Available Homepage Sections (13)

**1. Hero/Banner Slider**
- **Fields per slide:**
  - Subtitle (text)
  - Heading (text)
  - Description (textarea)
  - Button Text (text)
  - Button Link (URL)
  - Background Image (media)
  - Order (number)
  - Active (boolean)
- **Settings:**
  - Auto-play (boolean)
  - Auto-play delay (number)
  - Animation effect (select: fade, slide)

**2. Features Section**
- **Fields:**
  - Section Heading (text)
  - Section Subheading (text)
  - Review Count (number)
  - Feature Items (repeater):
    - Icon (icon picker / image)
    - Title (text)
    - Description (textarea)
    - Order (number)

**3. About Section**
- **Fields:**
  - Section Title (text)
  - Section Subtitle (text)
  - Description (WYSIWYG)
  - Image 1 (media)
  - Image 2 (media)
  - Video URL (text)
  - Success Rate Percentage (number)
  - Button Text (text)
  - Button Link (URL)
  - Skill Bars (repeater):
    - Skill Name (text)
    - Percentage (number)

**4. Services Section**
- **Fields:**
  - Section Heading (text)
  - Section Subheading (text)
  - Number of Services to Display (number)
  - View All Button Text (text)
  - View All Button Link (URL)
- **Note:** Service items pulled from Services module

**5. CTA Section 1**
- **Fields:**
  - Heading (text)
  - Phone Number (text)
  - Label Text (text)
  - Background Image (media)

**6. Why Choose Us Section**
- **Fields:**
  - Heading (text)
  - Description (textarea)
  - Phone Number (text)
  - Background Image (media)
  - Button Text (text)
  - Button Link (URL)
  - Features (repeater):
    - Icon (icon picker)
    - Title (text)

**7. Portfolio/Projects Section**
- **Fields:**
  - Section Heading (text)
  - Number of Projects to Display (number)
  - Auto-play (boolean)
  - View All Button Text (text)
  - View All Button Link (URL)
- **Note:** Project items pulled from Projects module

**8. Work Process Section**
- **Fields:**
  - Section Heading (text)
  - Steps (4 items - repeater):
    - Step Number (number)
    - Image (media)
    - Title (text)
    - Description (textarea)

**9. Team Section**
- **Fields:**
  - Section Heading (text)
  - Number of Team Members to Display (number)
- **Note:** Team items pulled from Team Members module

**10. Testimonial Section**
- **Fields:**
  - Section Heading (text)
  - Number of Testimonials to Display (number)
  - Auto-play (boolean)
  - Show Navigation Arrows (boolean)
- **Note:** Testimonial items pulled from Testimonials module

**11. Brand/Partners Section**
- **Fields:**
  - Section Heading (text)
  - Auto-scroll Speed (number)
- **Note:** Brand logos pulled from Partners module

**12. Blog Section**
- **Fields:**
  - Section Heading (text)
  - Number of Posts to Display (number)
  - View More Button Text (text)
  - View More Button Link (URL)
- **Note:** Blog posts pulled from Blog module

**13. Footer CTA Section**
- **Fields:**
  - Heading (text)
  - Button Text (text)
  - Button Link (URL)
  - Phone Number (text)
  - Character Image (media)
  - Background Image (media)

---

### 2.3 Navigation/Menu Management
**Route:** `/admin/menus`

#### Features
- ✅ Multiple menus support (Header, Footer, Sidebar)
- ✅ Multi-level menu items (3 levels)
- ✅ Drag & drop reordering
- ✅ Nested menu structure
- ✅ Menu item types: Page, URL, Dropdown

#### Menu Item Fields
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| Menu Location | Select | Yes | Header/Footer/Sidebar |
| Title | Text | Yes | Display text |
| Type | Select | Yes | Page/Custom URL/Dropdown |
| Link | URL/Select | Conditional | URL or page selection |
| Target | Select | No | _self / _blank |
| Icon | Icon Picker | No | Menu icon (optional) |
| Parent | Select | No | Parent menu item |
| Order | Number | Auto | Sort order |
| Active | Boolean | Yes | Show/hide |

---

### 2.4 Header Management
**Route:** `/admin/header-settings`

#### Top Bar Settings
- Enable/Disable Top Bar
- Email Address (text)
- Email Link (boolean)
- Physical Address (text)
- Address Link (text - Google Maps URL)
- "Follow Us" Label (text)
- Social Links (repeater):
  - Platform (select: Facebook, Twitter, LinkedIn, etc.)
  - URL (text)
  - Icon (auto-set based on platform)

#### Main Navigation Settings
- Logo (media)
- Logo Dark Mode (media)
- Logo Link (URL - default: home)
- CTA Button Text (text)
- CTA Button Link (URL)
- Show Search Icon (boolean)
- Show Sidebar Toggle (boolean)

#### Sidebar Popup Settings
- Sidebar Logo (media)
- Description Text (textarea)
- Contact Cards (fixed 3):
  - Phone Number 1 (text)
  - Phone Number 2 (text)
  - Email Address (text)
  - Physical Address (text)
- Social Media Icons (same as top bar)

---

### 2.5 Footer Management
**Route:** `/admin/footer-settings`

#### Footer Main Section (4 Columns)

**Column 1: Company Info**
- Footer Logo (media)
- Company Description (textarea)
- Social Links (repeater - same structure as header)

**Column 2: Contact Information**
- Phone Numbers (repeater):
  - Phone Number (text)
  - Label (text - e.g., "Support", "Sales")

**Column 3: Quick Links**
- Menu Selection (select existing menu)
- OR Custom Links (repeater):
  - Link Text (text)
  - Link URL (text)

**Column 4: Newsletter**
- Newsletter Heading (text)
- Newsletter Description (text)
- Placeholder Text (text)
- Button Text (text)
- Terms Checkbox Text (text)
- Enable Newsletter (boolean)

#### Footer Bottom (Copyright Bar)
- Copyright Text (text)
- Show Terms Link (boolean)
- Terms Link URL (text)
- Show Privacy Link (boolean)
- Privacy Link URL (text)

---

## 3. BUSINESS MANAGEMENT MODULES

### 3.1 Products Management
**Route:** `/admin/products`

#### Features
- ✅ List all products (table view with search/filter)
- ✅ Create product
- ✅ Edit product
- ✅ Delete product
- ✅ Bulk actions (delete, publish, unpublish)
- ✅ Image gallery management
- ✅ Category assignment
- ✅ Featured product toggle

#### Product Fields
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| Name | Text | Yes | Product name |
| Slug | Text | Auto | URL slug |
| Category | Select | Yes | Product category |
| Short Description | Textarea | No | Brief description |
| Description | WYSIWYG | No | Full description |
| Features | Repeater | No | Key features list |
| Specifications | Repeater | No | Technical specs |
| Price | Number | No | Product price |
| Featured Image | Media | Yes | Main product image |
| Gallery Images | Media Gallery | No | Multiple images |
| Featured | Boolean | No | Show on homepage |
| Status | Select | Yes | Draft/Published |
| Meta Title | Text | No | SEO title |
| Meta Description | Textarea | No | SEO description |
| Order | Number | No | Display order |
| Views | Number | Auto | View count |
| Created At | Timestamp | Auto | |
| Updated At | Timestamp | Auto | |

#### Product Categories
- Manage categories
- Category name, slug, description
- Category image
- Parent category support

---

### 3.2 Services Management
**Route:** `/admin/services`

#### Features
- ✅ List all services
- ✅ Create service
- ✅ Edit service
- ✅ Delete service
- ✅ Category management
- ✅ Icon selection
- ✅ Layout selection (full-width, left sidebar, right sidebar)

#### Service Fields
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| Service Name | Text | Yes | Service title |
| Slug | Text | Auto | URL slug |
| Category | Select | No | Service category |
| Icon | Icon Picker/Media | Yes | Service icon |
| Short Description | Textarea | Yes | Brief description (for cards) |
| Full Description | WYSIWYG | Yes | Complete description |
| Benefits | Repeater | No | Service benefits |
| Process Steps | Repeater | No | How it works |
| Featured Image | Media | Yes | Main service image |
| Gallery Images | Media Gallery | No | Additional images |
| Layout | Select | Yes | Full/Left Sidebar/Right Sidebar |
| Featured | Boolean | No | Show on homepage |
| Price Starting From | Number | No | Starting price |
| Status | Select | Yes | Draft/Published |
| Meta Title | Text | No | SEO title |
| Meta Description | Textarea | No | SEO description |
| Order | Number | No | Display order |
| Views | Number | Auto | View count |

#### Service Categories
- Category CRUD
- Name, slug, description, icon

---

### 3.3 Projects/Portfolio Management
**Route:** `/admin/projects`

#### Features
- ✅ List all projects (grid/table view)
- ✅ Create project
- ✅ Edit project
- ✅ Delete project
- ✅ Category/tag management
- ✅ Image gallery
- ✅ Isotope filtering support

#### Project Fields
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| Project Name | Text | Yes | Project title |
| Slug | Text | Auto | URL slug |
| Category | Select | Yes | Project category |
| Tags | Multi-Select | No | Project tags |
| Client Name | Text | No | Client |
| Project Date | Date | No | Completion date |
| Location | Text | No | Project location |
| Budget | Number | No | Project budget |
| Short Description | Textarea | Yes | Brief description |
| Full Description | WYSIWYG | Yes | Complete description |
| Challenge | WYSIWYG | No | Project challenges |
| Solution | WYSIWYG | No | Solutions provided |
| Results | WYSIWYG | No | Project outcomes |
| Featured Image | Media | Yes | Main project image |
| Gallery Images | Media Gallery | Yes | Project photos |
| Video URL | Text | No | Project video |
| Website URL | Text | No | Project website |
| Featured | Boolean | No | Show on homepage |
| Status | Select | Yes | Draft/Published |
| Meta Title | Text | No | SEO title |
| Meta Description | Textarea | No | SEO description |
| Views | Number | Auto | View count |

#### Project Categories & Tags
- Category CRUD
- Tag CRUD
- Assign colors for Isotope filters

---

### 3.4 Pricing Plans Management
**Route:** `/admin/pricing`

#### Features
- ✅ List all plans
- ✅ Create plan
- ✅ Edit plan
- ✅ Delete plan
- ✅ Reorder plans
- ✅ Set popular badge

#### Pricing Plan Fields
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| Plan Name | Text | Yes | Plan title |
| Price | Number | Yes | Plan price |
| Currency | Select | Yes | USD, EUR, etc. |
| Billing Period | Select | Yes | Monthly/Yearly/One-time |
| Description | Textarea | No | Plan description |
| Features | Repeater | Yes | Plan features list |
| Feature Available | Boolean | Per item | Checkmark or X |
| Button Text | Text | Yes | CTA button text |
| Button Link | URL | No | CTA button link |
| Popular Badge | Boolean | No | Highlight as popular |
| Order | Number | Yes | Display order |
| Status | Select | Yes | Active/Inactive |

---

## 4. CONTENT MANAGEMENT MODULES

### 4.1 Blog Management
**Route:** `/admin/blog`

#### Blog Posts Features
- ✅ List all posts (table view)
- ✅ Create post
- ✅ Edit post
- ✅ Delete post
- ✅ Category & tag management
- ✅ Author assignment
- ✅ Featured posts
- ✅ Scheduled publishing
- ✅ Comments management (if enabled)

#### Blog Post Fields
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| Title | Text | Yes | Post title |
| Slug | Text | Auto | URL slug |
| Category | Select | Yes | Post category |
| Tags | Multi-Select | No | Post tags |
| Author | Select | Yes | Author (User) |
| Excerpt | Textarea | Yes | Short description |
| Content | WYSIWYG | Yes | Full post content |
| Featured Image | Media | Yes | Post thumbnail |
| Gallery | Media Gallery | No | Additional images |
| Layout | Select | Yes | Full/Left/Right Sidebar |
| Reading Time | Number | Auto | Calculated |
| Featured | Boolean | No | Show on homepage |
| Status | Select | Yes | Draft/Published/Scheduled |
| Publish Date | DateTime | Yes | Publication date/time |
| Meta Title | Text | No | SEO title |
| Meta Description | Textarea | No | SEO description |
| Views | Number | Auto | View count |
| Likes | Number | Auto | Like count |

#### Blog Categories
- CRUD operations
- Name, slug, description
- Category image
- Parent category support
- Post count

#### Blog Tags
- CRUD operations
- Tag name, slug
- Tag color
- Post count

---

### 4.2 Team Management
**Route:** `/admin/team`

#### Features
- ✅ List all team members
- ✅ Create team member
- ✅ Edit team member
- ✅ Delete team member
- ✅ Department/role management
- ✅ Team member profiles

#### Team Member Fields
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| Full Name | Text | Yes | Member name |
| Slug | Text | Auto | URL slug |
| Position | Text | Yes | Job title |
| Department | Select | No | Department |
| Email | Email | No | Contact email |
| Phone | Text | No | Contact phone |
| Bio | WYSIWYG | No | Full biography |
| Short Bio | Textarea | No | Brief description |
| Photo | Media | Yes | Profile photo |
| Skills | Repeater | No | Skills with percentages |
| Experience Years | Number | No | Years of experience |
| Social Links | Repeater | No | Social media profiles |
| Featured | Boolean | No | Show on homepage |
| Order | Number | No | Display order |
| Status | Select | Yes | Active/Inactive |

#### Departments
- CRUD operations
- Department name, description

---

### 4.3 Testimonials Management
**Route:** `/admin/testimonials`

#### Features
- ✅ List all testimonials
- ✅ Create testimonial
- ✅ Edit testimonial
- ✅ Delete testimonial
- ✅ Approve/pending status
- ✅ Star rating

#### Testimonial Fields
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| Client Name | Text | Yes | Customer name |
| Position | Text | No | Job title |
| Company | Text | No | Company name |
| Company Logo | Media | No | Company logo |
| Rating | Number | Yes | 1-5 stars |
| Testimonial Text | Textarea | Yes | Review content |
| Avatar | Media | No | Client photo |
| Featured | Boolean | No | Show on homepage |
| Status | Select | Yes | Pending/Approved |
| Date | Date | Auto | Submission date |
| Order | Number | No | Display order |

---

### 4.4 Partners/Brands Management
**Route:** `/admin/partners`

#### Features
- ✅ List all partners
- ✅ Create partner
- ✅ Edit partner
- ✅ Delete partner
- ✅ Reorder partners

#### Partner Fields
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| Partner Name | Text | Yes | Company name |
| Logo | Media | Yes | Partner logo |
| Logo Dark Mode | Media | No | Dark version |
| Website URL | URL | No | Partner website |
| Description | Textarea | No | Partner description |
| Featured | Boolean | No | Show on homepage |
| Order | Number | No | Display order |
| Status | Select | Yes | Active/Inactive |

---

### 4.5 FAQ Management
**Route:** `/admin/faqs`

#### Features
- ✅ List all FAQs
- ✅ Create FAQ
- ✅ Edit FAQ
- ✅ Delete FAQ
- ✅ Category management
- ✅ Reorder FAQs

#### FAQ Fields
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| Question | Text | Yes | FAQ question |
| Answer | WYSIWYG | Yes | FAQ answer |
| Category | Select | No | FAQ category |
| Order | Number | No | Display order |
| Status | Select | Yes | Published/Draft |

#### FAQ Categories
- Category name, slug, order

---

## 5. SETTINGS & CONFIGURATION

### 5.1 General Settings
**Route:** `/admin/settings/general`

#### Site Information
- Site Name (text)
- Site Tagline (text)
- Site Description (textarea)
- Admin Email (email)
- Contact Email (email)
- Contact Phone (text)
- Contact Phone 2 (text)
- Business Address (textarea)
- Business Hours (WYSIWYG)
- Google Maps URL (text)
- Google Maps Embed Code (textarea)

#### Social Media Links
- Facebook URL
- Twitter URL
- LinkedIn URL
- Instagram URL
- YouTube URL
- Behance URL

#### Logos & Branding
- Main Logo (media)
- Logo Dark Mode (media)
- Footer Logo (media)
- Favicon (media)
- Admin Logo (media)

---

### 5.2 Appearance Settings
**Route:** `/admin/settings/appearance`

#### Theme Settings
- Primary Color (color picker)
- Secondary Color (color picker)
- Accent Color (color picker)
- Dark Mode Enabled (boolean)
- Default Mode (select: light/dark)

#### Layout Settings
- Sidebar Style (select)
- Header Style (select)
- Footer Style (select)

---

### 5.3 Email Settings
**Route:** `/admin/settings/email`

#### SMTP Configuration
- SMTP Host
- SMTP Port
- SMTP Username
- SMTP Password
- Encryption (SSL/TLS)
- From Email
- From Name

#### Email Templates
- Contact Form Notification
- Quote Request Notification
- Newsletter Subscription Confirmation

---

## 6. USER & PERMISSION MANAGEMENT

### 6.1 Users Management
**Route:** `/admin/users`

#### Features
- ✅ List all users
- ✅ Create user
- ✅ Edit user
- ✅ Delete user
- ✅ Assign roles
- ✅ Activate/deactivate users

#### User Fields
- Name
- Email
- Password
- Role
- Avatar
- Status
- Last Login

---

### 6.2 Roles & Permissions
**Route:** `/admin/roles`

#### Default Roles
1. **Super Admin** - Full access
2. **Admin** - All except system settings
3. **Editor** - Content management only
4. **Author** - Create/edit own content

#### Permission Categories
- Dashboard
- Pages
- Products
- Services
- Projects
- Blog
- Team
- Testimonials
- Partners
- FAQs
- Pricing
- Forms
- Settings
- Users

---

## 7. FORMS & COMMUNICATION

### 7.1 Contact Messages
**Route:** `/admin/contact-messages`

#### Features
- ✅ List all messages
- ✅ View message
- ✅ Mark as read/unread
- ✅ Reply to message
- ✅ Delete message
- ✅ Export messages

---

### 7.2 Quote Requests
**Route:** `/admin/quote-requests`

#### Features
- ✅ List all requests
- ✅ View request details
- ✅ Change status (pending/processing/completed/declined)
- ✅ Assign to user
- ✅ Add notes
- ✅ Export requests

---

### 7.3 Newsletter Subscribers
**Route:** `/admin/newsletter`

#### Features
- ✅ List all subscribers
- ✅ Export subscribers
- ✅ Send newsletter
- ✅ Unsubscribe management

---

## 8. MEDIA MANAGEMENT

### Media Library
**Route:** `/admin/media`

#### Features
- ✅ Upload files (images, documents, videos)
- ✅ Grid/list view
- ✅ Search media
- ✅ Filter by type
- ✅ Organize in folders
- ✅ Edit image (crop, resize)
- ✅ View file details
- ✅ Delete files
- ✅ Bulk upload
- ✅ Dark mode variant support

---

## 9. SEO MANAGEMENT

### SEO Settings
**Route:** `/admin/settings/seo`

#### Global SEO
- Default Meta Title Template
- Default Meta Description
- Default Meta Keywords
- Open Graph Image
- Twitter Card Type

#### Per-Page SEO
- Meta Title
- Meta Description
- Meta Keywords
- OG Title
- OG Description
- OG Image

---

## 10. ACTIVITY LOGGING

### Activity Logs
**Route:** `/admin/activity-logs`

#### Logged Actions
- User login/logout
- Content created/updated/deleted
- Settings changed
- File uploaded/deleted

---

## SUMMARY

### Total CMS Modules: 25+
### Total Database Tables Required: 30+
### Total Admin Pages: 50+

**Status:** ✅ CMS Feature Mapping Complete
**Next:** Database Design & Architecture
