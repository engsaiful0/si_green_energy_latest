<?php

namespace App\Support\Pages;

use App\Support\Company;
use App\Support\PageSections;

/**
 * Homepage (Slaze "Solar Energy" home, index-2.html).
 */
class HomePage
{
    public static function info(): array
    {
        return [
            'label' => 'Home Page',
            'route' => 'home',
            'views' => 'frontend.home.sections',
        ];
    }

    public static function pageSection(): array
    {
        return PageSections::pageSettings(false, 'Home', 'Si Green Energy designs, supplies and installs on-grid, off-grid and hybrid solar power systems for homes, businesses and industry in Chattogram and across Bangladesh.');
    }

    public static function sections(): array
    {
        return [
            'banner' => [
                'name' => 'Banner Slider',
                'source' => 'sliders',
                'description' => 'Hero slider. Slides are managed under Home Sliders.',
                'manage' => ['label' => 'Manage Slides', 'route' => 'admin.sliders.index'],
                'fields' => [
                    'shape_image' => ['label' => 'Decorative Shape', 'type' => 'image', 'default' => 'img/shape/shape-3.png'],
                ],
                'repeaters' => [
                    'counters' => [
                        'label' => 'Counters',
                        'item_label' => 'Counter',
                        'fields' => [
                            'value' => ['label' => 'Number', 'type' => 'text', 'help' => 'Use figures you can verify.'],
                            'label' => ['label' => 'Label', 'type' => 'text'],
                        ],
                        'default' => [
                            ['value' => '10', 'label' => 'Solar Services'],
                            ['value' => '8', 'label' => 'Product Categories'],
                        ],
                    ],
                ],
            ],

            'features' => [
                'name' => 'Features',
                'description' => 'Trusted-partner strip below the banner.',
                'fields' => [
                    'title' => ['label' => 'Title', 'type' => 'text', 'default' => 'Your Solar Energy Partner in Bangladesh'],
                    'client_image' => ['label' => 'Small Image', 'type' => 'image', 'default' => 'img/avatar/user.png'],
                    'client_text' => ['label' => 'Small Image Text', 'type' => 'text', 'default' => 'Homes, businesses & industry'],
                    'background_image' => ['label' => 'Background Shape', 'type' => 'image', 'default' => 'img/shape/shape-10.png'],
                ],
                'repeaters' => [
                    'items' => [
                        'label' => 'Feature Items',
                        'item_label' => 'Feature',
                        'fields' => [
                            'icon' => ['label' => 'Icon Class', 'type' => 'icon'],
                            'title' => ['label' => 'Title', 'type' => 'text'],
                            'text' => ['label' => 'Text', 'type' => 'textarea'],
                        ],
                        'default' => [
                            ['icon' => 'flaticon-profit', 'title' => 'Lower Energy Costs', 'text' => 'Generate your own electricity and rely less on grid power and diesel generators.'],
                            ['icon' => 'flaticon-best-customer-experience', 'title' => 'Engineering Support', 'text' => 'Systems designed around your site, load profile and budget.'],
                        ],
                    ],
                ],
            ],

            'about' => [
                'name' => 'About',
                'description' => 'Company introduction with images and a video link.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'About Si Green Energy'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Clean, Reliable Solar Power for Bangladesh'],
                    'text' => ['label' => 'Text', 'type' => 'textarea', 'default' => "Si Green Energy is a Chattogram-based solar energy company. We design, supply and install solar power systems for homes, shops, offices, factories and farms.\n\nEvery project starts with a site survey and an assessment of how you use electricity, so the system we recommend fits your roof, your load and your budget."],
                    'image_main' => ['label' => 'Main Image', 'type' => 'image', 'default' => 'img/about/about-6.jpg'],
                    'image_secondary' => ['label' => 'Secondary Image', 'type' => 'image', 'default' => 'img/about/about-4.jpg'],
                    'progress_percent' => ['label' => 'Circle Percentage (optional)', 'type' => 'number', 'default' => null, 'help' => 'Leave empty to hide the circle.'],
                    'progress_label' => ['label' => 'Circle Label', 'type' => 'text', 'default' => ''],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'Our Company Profile'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/company-profile'],
                    'video_url' => ['label' => 'Video URL (YouTube, optional)', 'type' => 'url', 'default' => ''],
                    'video_label' => ['label' => 'Video Label', 'type' => 'text', 'default' => 'Watch Video'],
                    'shape_light' => ['label' => 'Background Shape (Light)', 'type' => 'image', 'default' => 'img/shape/shape-11.png'],
                    'shape_dark' => ['label' => 'Background Shape (Dark)', 'type' => 'image', 'default' => 'img/shape/shape-11-dark.png'],
                    'image_shape' => ['label' => 'Image Shape', 'type' => 'image', 'default' => 'img/shape/shape-12.png'],
                ],
                'repeaters' => [
                    'skills' => [
                        'label' => 'Progress Bars (optional)',
                        'item_label' => 'Bar',
                        'fields' => [
                            'label' => ['label' => 'Label', 'type' => 'text'],
                            'percent' => ['label' => 'Percent', 'type' => 'number'],
                        ],
                        'default' => [],
                    ],
                ],
            ],

            'services' => [
                'name' => 'Services',
                'source' => 'services',
                'description' => 'Published services (featured first). Services are managed under Services.',
                'manage' => ['label' => 'Manage Services', 'route' => 'admin.services.index'],
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'What We Do'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Solar Energy Services'],
                    'limit' => ['label' => 'Number of Services', 'type' => 'number', 'default' => 6],
                    'link_text' => ['label' => 'Card Link Text', 'type' => 'text', 'default' => 'View Details'],
                    'background_image' => ['label' => 'Section Background', 'type' => 'image', 'default' => 'img/shape/shape-9.png'],
                    'card_background' => ['label' => 'Card Background', 'type' => 'image', 'default' => 'img/shape/shape-5.png'],
                ],
            ],

            'cta' => [
                'name' => 'Call to Action',
                'description' => 'Phone call-to-action banner.',
                'fields' => [
                    'title' => ['label' => 'Title (one line)', 'type' => 'text', 'max' => 60, 'default' => 'Talk to Our Solar Engineers Today', 'help' => 'Shown on one line on desktop: keep it under about 40 characters.'],
                    'icon' => ['label' => 'Icon Class', 'type' => 'icon', 'default' => 'flaticon-phone-call'],
                    'contact_label' => ['label' => 'Contact Label', 'type' => 'text', 'default' => 'Call Si Green Energy'],
                    'phone' => ['label' => 'Phone', 'type' => 'text', 'default' => Company::PHONE],
                    'background_image' => ['label' => 'Background', 'type' => 'image', 'default' => 'img/shape/shape-6.png'],
                ],
            ],

            'why_choose' => [
                'name' => 'Why Choose Us',
                'description' => 'Reasons to choose us, with image and contact line.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Why Choose Us'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Engineering-Led Solar Solutions You Can Rely On'],
                    'text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'We size every system from your actual electricity use, select suitable components and install them to proper electrical and structural standards, then stay available for maintenance and support.'],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'Explore Solutions'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/solutions'],
                    'contact_text' => ['label' => 'Contact Text', 'type' => 'textarea', 'default' => "Have a question about solar?\nCall us at"],
                    'phone' => ['label' => 'Phone', 'type' => 'text', 'default' => Company::PHONE],
                    'image' => ['label' => 'Image', 'type' => 'image', 'default' => 'img/pages/choose-us-1.jpg'],
                ],
                'repeaters' => [
                    'items' => [
                        'label' => 'Reasons',
                        'item_label' => 'Reason',
                        'fields' => [
                            'icon' => ['label' => 'Icon Class', 'type' => 'icon'],
                            'title' => ['label' => 'Title', 'type' => 'text'],
                        ],
                        'default' => [
                            ['icon' => 'flaticon-system', 'title' => 'Site-Specific Design'],
                            ['icon' => 'flaticon-solar-panel-2', 'title' => 'Quality Components'],
                            ['icon' => 'flaticon-maintenance', 'title' => 'Local Support'],
                        ],
                    ],
                ],
            ],

            'portfolio' => [
                'name' => 'Project Gallery',
                'source' => 'projects',
                'description' => 'Published projects (featured first). Hidden automatically while no project is published.',
                'manage' => ['label' => 'Manage Projects', 'route' => 'admin.projects.index'],
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Our Work'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Recent Solar Projects'],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'View All Projects'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/projects'],
                    'limit' => ['label' => 'Number of Projects', 'type' => 'number', 'default' => 6],
                ],
            ],

            'work_process' => [
                'name' => 'Work Process',
                'description' => 'Step-by-step process cards.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'How We Work'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'From Site Survey to Switch-On'],
                ],
                'repeaters' => [
                    'steps' => [
                        'label' => 'Steps',
                        'item_label' => 'Step',
                        'fields' => [
                            'label' => ['label' => 'Step Label', 'type' => 'text', 'help' => 'e.g. Step 01'],
                            'title' => ['label' => 'Title', 'type' => 'text'],
                            'text' => ['label' => 'Text', 'type' => 'textarea'],
                            'image' => ['label' => 'Image', 'type' => 'image'],
                        ],
                        'default' => [
                            ['label' => 'Step 01', 'title' => 'Site Survey', 'text' => 'We assess your roof or land, shading and electricity use.', 'image' => 'img/pages/work-1.jpg'],
                            ['label' => 'Step 02', 'title' => 'System Design', 'text' => 'We size panels, inverter and storage and share a clear proposal.', 'image' => 'img/pages/work-2.jpg'],
                            ['label' => 'Step 03', 'title' => 'Installation', 'text' => 'Our team installs the structure, panels, wiring and protection.', 'image' => 'img/pages/work-3.jpg'],
                            ['label' => 'Step 04', 'title' => 'Commissioning & Support', 'text' => 'We test, hand over and support the system after installation.', 'image' => 'img/pages/work-4.jpg'],
                        ],
                    ],
                ],
            ],

            'gallery' => [
                'name' => 'Gallery Carousel',
                'source' => 'gallery',
                'description' => 'Published gallery images marked "Show on homepage", in their homepage order. Managed under Gallery.',
                'manage' => ['label' => 'Manage Homepage Images', 'route' => 'admin.gallery.home'],
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Gallery'],
                    'title' => ['label' => 'Title', 'type' => 'text', 'default' => 'Solar Work in Pictures'],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'View All Gallery'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/gallery'],
                    'limit' => ['label' => 'Maximum Images', 'type' => 'number', 'default' => 12],
                    'autoplay_delay' => ['label' => 'Autoplay Delay (seconds)', 'type' => 'number', 'default' => 4],
                ],
            ],

            'team' => [
                'name' => 'Team',
                'source' => 'team',
                'description' => 'Active team members (featured first). Hidden automatically while no member is active.',
                'manage' => ['label' => 'Manage Team', 'route' => 'admin.team.index'],
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Our People'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Solar Design Engineers'],
                    'limit' => ['label' => 'Number of Members', 'type' => 'number', 'default' => 4],
                ],
            ],

            'testimonials' => [
                'name' => 'Testimonials',
                'source' => 'testimonials',
                'description' => 'Approved testimonials (featured first). Hidden automatically while none is approved.',
                'manage' => ['label' => 'Manage Testimonials', 'route' => 'admin.testimonials.index'],
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Testimonials'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'What Our Customers Say'],
                    'limit' => ['label' => 'Number of Testimonials', 'type' => 'number', 'default' => 6],
                    'background_image' => ['label' => 'Background', 'type' => 'image', 'default' => 'img/shape/shape-8.png'],
                ],
            ],

            'brands' => [
                'name' => 'Partner Logos',
                'source' => 'partners',
                'description' => 'Active partner logos slider. Hidden automatically while no partner is active.',
                'manage' => ['label' => 'Manage Partners', 'route' => 'admin.partners.index'],
                'fields' => [
                    'limit' => ['label' => 'Number of Logos', 'type' => 'number', 'default' => 12],
                ],
            ],

            'blog' => [
                'name' => 'Latest Blog',
                'source' => 'blog',
                'description' => 'Latest published blog posts. Managed under Blog Posts.',
                'manage' => ['label' => 'Manage Blog Posts', 'route' => 'admin.blog-posts.index'],
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Solar Insights'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Latest News & Guides'],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'Read Our Blog'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/blog'],
                    'limit' => ['label' => 'Number of Posts', 'type' => 'number', 'default' => 3],
                ],
            ],

            'footer_cta' => [
                'name' => 'Footer Call to Action',
                'description' => 'Call-to-action box above the footer (same design as on every inner page).',
                'fields' => [
                    'title' => ['label' => 'Title (one line)', 'type' => 'text', 'max' => 60, 'default' => "Let's Build a Sustainable Energy Future", 'help' => 'Shown on one line on desktop: keep it under about 40 characters.'],
                    'text' => ['label' => 'Description', 'type' => 'textarea', 'default' => 'Share your location and electricity needs, and our engineers will recommend a solar system that suits your home or business.'],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'Contact Us'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/contact'],
                    'help_label' => ['label' => 'Phone Label', 'type' => 'text', 'default' => 'Call our team'],
                    'phone' => ['label' => 'Phone', 'type' => 'text', 'default' => Company::PHONE],
                    'image' => ['label' => 'Image', 'type' => 'image', 'default' => 'img/avatar/avatar-5.png'],
                    'background_image' => ['label' => 'Background', 'type' => 'image', 'default' => 'img/shape/shape-7.png'],
                ],
            ],
        ];
    }
}
