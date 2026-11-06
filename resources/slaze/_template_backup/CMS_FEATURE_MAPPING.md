# CMS FEATURE MAPPING
## HTML Template → Admin CMS Functionality

**Database:** si_green_energy
**Laravel Version:** 8.3

---

## MAPPING TABLE

| # | HTML Page/Section | Editable Fields | Admin Module | Database Table(s) | Blade Component | Priority |
|---|-------------------|-----------------|--------------|-------------------|-----------------|----------|
| **GLOBAL SETTINGS** |
| 1 | Site Logo (Header) | Logo image (light), Logo image (dark), Alt text | Settings > General | settings | layouts/header | High |
| 2 | Site Logo (Footer) | Footer logo image, Alt text | Settings > General | settings | layouts/footer | High |
| 3 | Favicon | Favicon image (multiple sizes) | Settings > General | settings | layouts/app | High |
| 4 | Top Bar (Email) | Email address, Display toggle | Settings > Contact Info | settings | partials/topbar | High |
| 5 | Top Bar (Address) | Physical address, Google Maps link, Display toggle | Settings > Contact Info | settings | partials/topbar | High |
| 6 | Top Bar Social | Social media links (FB, Twitter, Behance, LinkedIn), Display toggle | Settings > Social Media | social_links | partials/topbar | High |
| 7 | Preloader | Enable/disable, Animation type, Colors | Settings > Appearance | settings | partials/preloader | Medium |
| 8 | Dark Mode | Enable/disable, Default mode | Settings > Appearance | settings | partials/dark-mode-toggle | Medium |
| 9 | Search Box | Enable/disable, Placeholder text | Settings > General | settings | partials/search-box | Medium |
| 10 | Sidebar Popup | Logo, Description, Contact items, Social links, Enable/disable | Settings > General | settings | partials/sidebar-popup | Medium |
| 11 | Footer Text | Company address, Phone numbers, Email, Description | Settings > Contact Info | settings | layouts/footer | High |
| 12 | Footer Links | Quick links list (title, URL, order) | Navigation > Footer Menu | menu_items | layouts/footer | High |
| 13 | Footer Newsletter | Title, Description, Terms text, Enable/disable | Settings > Newsletter | settings | components/newsletter-form | High |
| 14 | Copyright Text | Copyright text, Links (Privacy, Terms) | Settings > General | settings | layouts/footer | High |
| 15 | Scroll to Top | Enable/disable, Style | Settings > Appearance | settings | partials/scroll-top | Low |
| 16 | CTA Button (Header) | Button text, Button URL, Display toggle | Settings > General | settings | layouts/header | High |
| **NAVIGATION MANAGEMENT** |
| 17 | Main Menu | Menu items, Dropdowns (unlimited depth), URLs, Ordering, Icons, Enable/disable | Navigation > Main Menu | menus, menu_items | layouts/header | High |
| 18 | Mobile Menu | Same as main menu (auto-synced) | Navigation > Main Menu | menus, menu_items | partials/mobile-menu | High |
| **HOMEPAGE SECTIONS** |
| 19 | Hero Slider | Slide image, Subtitle, Main title, Description, CTA button text, CTA button URL, Display order | Homepage > Hero Slider | homepage_sections (JSON config) or hero_slides | sections/hero | High |
| 20 | Hero Statistics | Counter 1 (number, label), Counter 2 (number, label), Enable/disable | Homepage > Hero Section | homepage_sections | sections/hero | High |
| 21 | Features Section | Section title, Customer review text, Customer avatar, Feature cards (icon, title, description), Enable/disable section | Homepage > Features | homepage_sections, features | sections/features | High |
| 22 | About Section | Images (2), Success rate percentage, Subtitle, Title, Description, Skill bars (name, percentage), CTA button, Video URL, Enable/disable | Homepage > About Section | homepage_sections | sections/about | High |
| 23 | Services Section (Home) | Section subtitle, Section title, Service cards (3 displayed), "View More" link, Enable/disable | Homepage > Services | homepage_sections, services | sections/services | High |
| 24 | CTA Banner | Title, Phone number, Phone label, Background image, Enable/disable | Homepage > CTA Banner | homepage_sections | sections/cta | High |
| 25 | Why Choose Us | Subtitle, Title, Description, Feature items (icon, title), CTA button, Phone text, Featured image, Enable/disable | Homepage > Why Choose Us | homepage_sections, features | sections/why-choose-us | High |
| 26 | Portfolio Slider | Subtitle, Title, "View All" button, Project items (image, category, title, link), Enable/disable | Homepage > Portfolio | homepage_sections, projects | sections/portfolio | High |
| 27 | Work Process | Subtitle, Title, Process steps (4 steps: image, number, title, description), Enable/disable | Homepage > Work Process | homepage_sections, work_process_steps | sections/work-process | High |
| 28 | Team Section (Home) | Subtitle, Title, Team members (4 displayed), Enable/disable | Homepage > Team | homepage_sections, team_members | sections/team | High |
| 29 | Testimonials (Home) | Subtitle, Title, Testimonial slides (image, rating, text, name, position, company logo), Navigation arrows, Enable/disable | Homepage > Testimonials | homepage_sections, testimonials | sections/testimonials | High |
| 30 | Brands/Partners | Brand logos (unlimited), Enable/disable slider | Homepage > Brands | homepage_sections, brands | sections/brands | Medium |
| 31 | Blog Section (Home) | Subtitle, Title, "More Blog" button, Blog posts (3 displayed), Enable/disable | Homepage > Blog | homepage_sections, blog_posts | sections/blog | High |
| 32 | Footer CTA | Title, CTA button text, CTA button URL, Phone number, Phone label, Avatar image, Enable/disable | Homepage > Footer CTA | homepage_sections | components/cta-banner | High |
| **ABOUT PAGE** |
| 33 | About: Features | Same as homepage features section | Pages > About > Features | page_sections | frontend/about | High |
| 34 | About: Main Content | Images (2), Subtitle, Title, Description, List items (checked), CTA button | Pages > About > Content | page_sections | frontend/about | High |
| 35 | About: Counters | Counter items (icon, number, label, suffix) - 4 items, Background image | Pages > About > Counters | page_sections, counters | frontend/about | High |
| 36 | About: Experience | Subtitle, Title, Description, Skill bars (3), Featured image | Pages > About > Experience | page_sections | frontend/about | High |
| 37 | About: Team | Same as homepage team section | Pages > About > Team | page_sections, team_members | frontend/about | High |
| 38 | About: Consultation | Subtitle, Title, Description, Mission card (icon, title, text), Vision card (icon, title, text), Customer satisfaction (number, image) | Pages > About > Consultation | page_sections | frontend/about | High |
| **SERVICES** |
| 39 | Services: Listing | Service items (icon/icon-class, title, description, link), Grid layout (2/3/4 columns), Ordering | Services > All Services | services | frontend/services/index | High |
| 40 | Services: Detail Page | Service title, Slug, Featured image, Banner image, Icon, Short description, Full description, Features list, Benefits list, Process steps, Gallery images, CTA button, SEO fields | Services > Edit Service | services, service_images | frontend/services/detail | High |
| 41 | Services: Categories | Category name, Slug, Description, Image, Ordering | Services > Categories | service_categories | frontend/services | Medium |
| 42 | Services: Why Choose Us | Subtitle, Title, Description, Feature items, Skill bars, Image | Pages > Services > Why Choose Us | page_sections | frontend/services | High |
| 43 | Services: Testimonials | Same as homepage testimonials | Pages > Services > Testimonials | page_sections, testimonials | frontend/services | Medium |
| **PRICING** |
| 44 | Pricing Plans | Plan name, Price, Currency, Billing period, Features list (text, included yes/no), Badge text, CTA button text, CTA button URL, Ordering, Enable/disable | Pricing > Plans | pricing_plans, pricing_features | frontend/pricing | High |
| **FAQ** |
| 45 | FAQ Items | Question, Answer, Category, Ordering, Enable/disable, Featured | FAQ > All FAQs | faqs, faq_categories | frontend/faq | High |
| 46 | FAQ Categories | Category name, Slug, Description, Ordering | FAQ > Categories | faq_categories | frontend/faq | Medium |
| **TESTIMONIALS** |
| 47 | Testimonials | Client name, Designation, Company name, Client image, Testimonial text, Rating (1-5 stars), Company logo, Ordering, Featured, Active/Inactive | Testimonials > All | testimonials | frontend/testimonials | High |
| **PROJECTS/PORTFOLIO** |
| 48 | Project Listing | Grid layout (2/3/4 columns), Filtering by category | Projects > All Projects | projects | frontend/projects | High |
| 49 | Project Details | Project title, Slug, Featured image, Gallery images (unlimited), Project date, Category, Client name, Location, Tags, Short description, Full description, Specifications, Status, Featured, Ordering, SEO fields | Projects > Edit Project | projects, project_images, project_categories | frontend/projects/detail | High |
| 50 | Project Categories | Category name, Slug, Description, Image, Ordering | Projects > Categories | project_categories | frontend/projects | Medium |
| **TEAM** |
| 51 | Team Listing | Grid layout (Style 1/2/3), Members per row | Team > All Members | team_members | frontend/team | High |
| 52 | Team Member | Name, Slug, Designation, Profile image, Short bio, Full bio, Email, Phone, Social media links (FB, Twitter, Instagram, LinkedIn), Ordering, Active/Inactive | Team > Edit Member | team_members | frontend/team | High |
| 53 | Team Detail Page | All team member fields, Extended content, Projects/achievements | Team > Edit Member | team_members | frontend/team/detail | Medium |
| **BLOG** |
| 54 | Blog Listing | Layout (Grid 2/3 columns, Standard with sidebar), Posts per page | Blog > Settings | settings | frontend/blog | High |
| 55 | Blog Post | Title, Slug, Featured image, Additional images, Short excerpt, Full content (WYSIWYG), Author, Category, Tags, Publication date, Featured post, Related posts, Read time (auto/manual), SEO title, Meta description, Meta keywords, Status (Draft/Published) | Blog > Edit Post | blog_posts, blog_categories, blog_tags, post_tag | frontend/blog | High |
| 56 | Blog Categories | Category name, Slug, Description, Image, Ordering | Blog > Categories | blog_categories | frontend/blog | High |
| 57 | Blog Tags | Tag name, Slug | Blog > Tags | blog_tags | frontend/blog | Medium |
| 58 | Blog Single Layout | Sidebar position (left/right/none), Related posts count, Comments enable/disable | Blog > Settings | settings | frontend/blog | Medium |
| 59 | Blog Sidebar Widgets | Recent posts, Categories, Tags, Search | Blog > Widgets | N/A (hardcoded widgets) | frontend/blog | Low |
| **CONTACT** |
| 60 | Contact Page Layout | Layout style (1 or 2) | Pages > Contact > Settings | settings | frontend/contact | Medium |
| 61 | Contact Info Boxes | Phone (icon, label, number), Email (icon, label, email), Location (icon, label, address), Hours (icon, label, hours) | Pages > Contact > Info | page_sections | frontend/contact | High |
| 62 | Contact Form Fields | Field labels, Placeholders, Required fields | Pages > Contact > Form | settings | frontend/contact | Medium |
| 63 | Contact Form Settings | Recipient email(s), Success message, Error message, Enable spam protection | Pages > Contact > Settings | settings | frontend/contact | High |
| 64 | Google Maps | Embed code/API key, Latitude, Longitude, Zoom level, Enable/disable | Pages > Contact > Map | settings | frontend/contact | High |
| 65 | Contact Submissions | View all submissions, Mark read/unread, Add notes, Delete/Archive, Export to CSV | Enquiries > Contact Messages | contact_messages | N/A (Admin only) | High |
| **REQUEST QUOTE** |
| 66 | Quote Form Fields | All field labels and placeholders (Name, Email, Company, Phone, Message, Website URL) | Pages > Quote > Form Fields | settings | frontend/quote | Medium |
| 67 | Quote Services Checkboxes | Service options (9 checkboxes: SEO, Web Design, Web Hosting, etc.) | Pages > Quote > Services | settings or quote_services table | frontend/quote | High |
| 68 | Quote Form Settings | Recipient email(s), Success message, Error message | Pages > Quote > Settings | settings | frontend/quote | High |
| 69 | Quote Testimonials (Sidebar) | Testimonial items displayed on quote page | Pages > Quote > Testimonials | page_sections, testimonials | frontend/quote | Medium |
| 70 | Quote Submissions | View all quote requests, Update status (New/Pending/In Progress/Quoted/Approved/Rejected/Completed), Add internal notes, Assign to admin, Search/filter, Export to CSV/Excel, Email notifications | Enquiries > Quote Requests | quote_requests | N/A (Admin only) | High |
| **NEWSLETTER** |
| 71 | Newsletter Settings | List provider (Mailchimp/etc), API keys, Success message | Settings > Newsletter | settings | N/A | Medium |
| 72 | Newsletter Subscribers | View all subscribers, Export list, Add/remove manually, Subscription date | Marketing > Subscribers | newsletter_subscribers | N/A (Admin only) | Medium |
| **CUSTOM PAGES** |
| 73 | Page Builder | Page title, Slug, Page content (WYSIWYG or section builder), Featured image, Banner image, SEO fields, Breadcrumb, Publish/Draft, Publication date | Pages > All Pages | pages | frontend/page | High |
| 74 | Page Sections | Reusable section templates that can be added to any page | Pages > Sections | page_sections | frontend/page | Medium |
| **MEDIA LIBRARY** |
| 75 | Media Management | Upload images, View all media, Search media, Delete media, Organize into folders, Preview images, Image dimensions, File size, Replace images | Media > Library | media | N/A (Admin interface) | High |
| **SEO** |
| 76 | Global SEO | Default meta title, Default meta description, Default OG image, Google Analytics ID, Google Search Console code, Robots.txt, Custom header scripts, Custom footer scripts | Settings > SEO | settings | layouts/app | High |
| 77 | Page-specific SEO | Override meta title, Override meta description, Override OG image, Custom keywords, Canonical URL | All content edit pages | Per-table columns | All frontend pages | High |
| 78 | Sitemap | Auto-generate XML sitemap, Include/exclude content types, Update frequency | Settings > SEO | N/A (generated) | N/A | Medium |
| **APPEARANCE** |
| 79 | Theme Colors | Primary color, Secondary color, Accent color, Custom CSS | Settings > Appearance | settings | N/A (CSS variables) | Low |
| 80 | Logo Management | Upload multiple logo versions (light/dark/sticky/footer) | Settings > General | settings | Multiple locations | High |
| 81 | Breadcrumb Settings | Enable/disable breadcrumbs, Background image, Text color | Settings > Appearance | settings | layouts/breadcrumb | Medium |
| 82 | Preloader | Enable/disable, Style, Animation speed | Settings > Appearance | settings | partials/preloader | Low |
| **USER MANAGEMENT** |
| 83 | Admin Users | Name, Email, Password, Role, Profile photo, Status | Users > All Users | users | N/A (Admin only) | High |
| 84 | Roles | Role name, Permissions | Users > Roles | roles, permissions | N/A (Admin only) | High |
| 85 | Permissions | Permission name, Module, Description | Users > Permissions | permissions | N/A (Admin only) | Medium |
| **ACTIVITY LOGS** |
| 86 | Activity Tracking | Log user actions (create/update/delete), Timestamp, User, IP address, Description | Logs > Activity | activity_logs | N/A (Admin only) | Low |
| **EMAIL SETTINGS** |
| 87 | SMTP Configuration | Mail driver, Host, Port, Username, Password, Encryption, Sender name, Sender email | Settings > Email | settings (.env) | N/A | High |
| 88 | Email Templates | Quote request notification, Contact form notification, Customer acknowledgement | Settings > Email Templates | email_templates or Blade files | N/A | Medium |

---

## ADMIN DASHBOARD WIDGETS

| Widget | Data Source | Display |
|--------|-------------|---------|
| Total Projects | projects table | Count + trend |
| Total Services | services table | Count |
| Total Blog Posts | blog_posts table | Count + recent |
| Total Team Members | team_members table | Count |
| Total Testimonials | testimonials table | Count |
| Quote Requests (This Month) | quote_requests table | Count + chart |
| Contact Messages (Unread) | contact_messages table | Count + list |
| Newsletter Subscribers | newsletter_subscribers table | Count + growth |
| Recent Activities | activity_logs table | List (10 latest) |
| Popular Blog Posts | blog_posts table | List (by views) |

---

## ADMIN SIDEBAR MENU STRUCTURE

```
Dashboard
  └─ Overview

Website Content
  ├─ Homepage Sections
  │   ├─ Hero Slider
  │   ├─ Features
  │   ├─ About Section
  │   ├─ Services Section
  │   ├─ CTA Banner
  │   ├─ Why Choose Us
  │   ├─ Portfolio
  │   ├─ Work Process
  │   ├─ Team Section
  │   ├─ Testimonials
  │   ├─ Brands
  │   ├─ Blog Section
  │   └─ Footer CTA
  ├─ Pages
  │   ├─ All Pages
  │   ├─ Add New Page
  │   └─ Page Sections
  ├─ Navigation
  │   ├─ Main Menu
  │   └─ Footer Menu
  └─ Media Library

Business
  ├─ Services
  │   ├─ All Services
  │   ├─ Add New Service
  │   └─ Categories
  ├─ Projects
  │   ├─ All Projects
  │   ├─ Add New Project
  │   └─ Categories
  └─ Pricing Plans

Company
  ├─ About Us Page
  ├─ Team Members
  │   ├─ All Members
  │   └─ Add New Member
  ├─ Testimonials
  ├─ Partners/Clients
  └─ FAQs
      ├─ All FAQs
      └─ Categories

Blog & News
  ├─ Blog Posts
  │   ├─ All Posts
  │   ├─ Add New Post
  │   ├─ Categories
  │   └─ Tags
  └─ Blog Settings

Enquiries
  ├─ Quote Requests
  ├─ Contact Messages
  └─ Newsletter Subscribers

Settings
  ├─ General Settings
  ├─ Contact Information
  ├─ Social Media
  ├─ Appearance
  ├─ Email Settings
  ├─ SEO Settings
  └─ Newsletter Settings

Administration
  ├─ Users
  ├─ Roles & Permissions
  ├─ Activity Logs
  ├─ My Profile
  └─ Logout
```

---

## CRUD OPERATION REQUIREMENTS

All admin modules must support:
- ✅ **Create** - Add new records
- ✅ **Read** - View all records (list/grid)
- ✅ **Update** - Edit existing records
- ✅ **Delete** - Remove records (with confirmation)
- ✅ **Search** - Search within records
- ✅ **Filter** - Filter by status, category, date, etc.
- ✅ **Sort** - Sort by columns
- ✅ **Pagination** - Handle large datasets
- ✅ **Bulk Actions** - Delete/update multiple records
- ✅ **Status Toggle** - Quick enable/disable
- ✅ **Ordering** - Drag-and-drop or manual ordering
- ✅ **Preview** - Preview before publishing
- ✅ **Duplicate** - Clone existing records

---

## VALIDATION RULES (Examples)

| Field Type | Validation Rules |
|------------|------------------|
| Title/Name | Required, String, Max:255 |
| Slug | Required, Unique, Alpha-dash, Max:255 |
| Email | Required, Email, Max:255 |
| Phone | String, Max:20 |
| Description | Nullable, String |
| Content | Nullable, String (HTML allowed) |
| Image | Nullable, Image, Max:2048KB, Mime:jpeg,png,jpg,webp |
| URL | Nullable, URL, Max:255 |
| Date | Nullable, Date |
| Status | Required, In:draft,published |
| Ordering | Nullable, Integer |
| Rating | Nullable, Integer, Min:1, Max:5 |

---

## IMAGE UPLOAD SPECIFICATIONS

| Image Type | Recommended Size | Max File Size | Format |
|------------|------------------|---------------|--------|
| Logo | 250x60px | 500KB | PNG (transparent) |
| Favicon | 32x32px, 180x180px | 50KB | PNG, ICO |
| Hero Slider | 1920x800px | 2MB | JPG, WebP |
| Featured Image | 800x600px | 1MB | JPG, WebP |
| Thumbnail | 400x300px | 500KB | JPG, WebP |
| Gallery Image | 1200x900px | 1.5MB | JPG, WebP |
| Team Photo | 400x400px | 500KB | JPG, PNG |
| Testimonial Avatar | 150x150px | 200KB | JPG, PNG |
| Brand Logo | 200x100px | 200KB | PNG (transparent) |
| Project Image | 1200x900px | 1.5MB | JPG, WebP |
| Blog Featured | 800x450px | 1MB | JPG, WebP |

**Image Processing:**
- Auto-resize uploaded images
- Generate multiple sizes (original, large, medium, thumbnail)
- Optimize images (compress without quality loss)
- Support WebP format for modern browsers
- Fallback to JPG for older browsers

---

## USER ROLES & PERMISSIONS MATRIX

| Permission | Super Admin | Admin | Content Manager | Editor | Enquiry Manager |
|------------|-------------|-------|-----------------|--------|-----------------|
| Dashboard Access | ✅ | ✅ | ✅ | ✅ | ✅ |
| Manage Homepage | ✅ | ✅ | ✅ | ❌ | ❌ |
| Manage Pages | ✅ | ✅ | ✅ | ✅ | ❌ |
| Manage Services | ✅ | ✅ | ✅ | ✅ | ❌ |
| Manage Projects | ✅ | ✅ | ✅ | ✅ | ❌ |
| Manage Blog | ✅ | ✅ | ✅ | ✅ | ❌ |
| Manage Team | ✅ | ✅ | ✅ | ❌ | ❌ |
| Manage Testimonials | ✅ | ✅ | ✅ | ❌ | ❌ |
| Manage FAQs | ✅ | ✅ | ✅ | ✅ | ❌ |
| View Quote Requests | ✅ | ✅ | ❌ | ❌ | ✅ |
| Manage Quote Requests | ✅ | ✅ | ❌ | ❌ | ✅ |
| View Contact Messages | ✅ | ✅ | ❌ | ❌ | ✅ |
| Manage Media Library | ✅ | ✅ | ✅ | ✅ | ❌ |
| Manage Settings | ✅ | ✅ | ❌ | ❌ | ❌ |
| Manage Users | ✅ | ❌ | ❌ | ❌ | ❌ |
| Manage Roles | ✅ | ❌ | ❌ | ❌ | ❌ |
| View Activity Logs | ✅ | ✅ | ❌ | ❌ | ❌ |

---

## NOTIFICATION SYSTEM

| Event | Notify Admin | Notify User | Method |
|-------|--------------|-------------|--------|
| New Quote Request | ✅ | ✅ (Acknowledgement) | Email |
| New Contact Message | ✅ | ✅ (Acknowledgement) | Email |
| New Newsletter Subscription | ✅ | ✅ (Confirmation) | Email |
| Quote Status Changed | ❌ | ✅ | Email |
| New Blog Post Published | ❌ | ❌ (Future: Subscribers) | Email |
| User Registration (Future) | ✅ | ✅ | Email |

---

## EXPORT FUNCTIONALITY

| Module | Export Format | Fields Included |
|--------|---------------|-----------------|
| Quote Requests | CSV, Excel | All fields + status + date |
| Contact Messages | CSV, Excel | All fields + read status + date |
| Newsletter Subscribers | CSV | Email, subscription date |
| Blog Posts | CSV | Title, category, author, date, status |
| Projects | CSV | Title, category, client, date, status |
| Team Members | CSV | Name, designation, email, phone |

---

## SEARCH FUNCTIONALITY

### Admin Search (Global)
Search across:
- Pages
- Blog posts
- Services
- Projects
- Team members
- FAQs

### Frontend Search
Search across:
- Blog posts
- Services
- Projects
- FAQs
- Pages (optional)

**Search Fields:**
- Title
- Content/Description
- Tags
- Categories

---

## CACHE MANAGEMENT

Cache the following for performance:
- Website settings
- Navigation menus
- Homepage sections
- Recent blog posts
- Testimonials
- FAQs

**Admin Feature:**
- "Clear Cache" button in admin dashboard
- Auto-clear cache on content update

---

## BACKUP & RESTORE

**Admin Features:**
- Database backup (manual/scheduled)
- Media files backup
- Download backup files
- Restore from backup
- Backup logs

---

**Status:** Complete mapping ready
**Next Step:** Create asset inventory
**Total Manageable Elements:** 89+ distinct CMS-manageable components
