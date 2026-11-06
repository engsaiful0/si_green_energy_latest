<?php

namespace App\Support\Pages;

use App\Support\Company;
use App\Support\PageSections;

/**
 * Contact page (Slaze contact-two.html).
 */
class ContactPage
{
    public static function info(): array
    {
        return [
            'label' => 'Contact Page',
            'route' => 'contact',
            'views' => 'frontend.contact.sections',
        ];
    }

    public static function pageSection(): array
    {
        return PageSections::pageSettings(true, 'Contact Us', 'Contact Si Green Energy in Chattogram for solar system design, installation, maintenance and quotations. Call 01813541292 or 01805993540.');
    }

    public static function cta(): array
    {
        return [
            'title' => 'Prefer to Talk? Call Our Team',
            'text' => 'Speak directly with our team about your solar project, a quotation or support for an existing system.',
            'button_text' => 'Call ' . Company::PHONE,
            'button_link' => 'tel:' . Company::PHONE,
        ];
    }

    public static function sections(): array
    {
        return [
            'contact' => [
                'name' => 'Contact Form & Details',
                'description' => 'Form headings and texts, contact detail cards and social links.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Contact us'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Have a Question About Solar?'],
                    'text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Tell us about your site, your electricity needs or your question. Our team will review your message and get back to you as soon as possible.'],
                    'name_placeholder' => ['label' => 'Name Field Placeholder', 'type' => 'text', 'default' => 'Full Name'],
                    'email_placeholder' => ['label' => 'Email Field Placeholder', 'type' => 'text', 'default' => 'Email Address'],
                    'phone_placeholder' => ['label' => 'Phone Field Placeholder', 'type' => 'text', 'default' => 'Phone Number'],
                    'subject_placeholder' => ['label' => 'Subject Field Placeholder', 'type' => 'text', 'default' => 'Subject'],
                    'message_placeholder' => ['label' => 'Message Field Placeholder', 'type' => 'text', 'default' => 'Message'],
                    'button_text' => ['label' => 'Submit Button Text', 'type' => 'text', 'default' => 'Submit Message'],
                    'success_message' => ['label' => 'Success Message', 'type' => 'textarea', 'default' => 'Thank you for contacting us! We will get back to you soon.'],
                    'social_title' => ['label' => 'Social Links Title', 'type' => 'text', 'default' => 'Follow Us', 'help' => 'Social links come from General Settings. Leave empty to hide them here.'],
                ],
                'repeaters' => [
                    'items' => [
                        'label' => 'Contact Detail Cards',
                        'item_label' => 'Card',
                        'fields' => [
                            'icon' => ['label' => 'Icon Class', 'type' => 'icon'],
                            'label' => ['label' => 'Label', 'type' => 'text', 'help' => 'e.g. Phone :'],
                            'value' => ['label' => 'Value', 'type' => 'text'],
                            'link' => ['label' => 'Link (optional)', 'type' => 'url', 'help' => 'tel:..., mailto:... or a map URL'],
                        ],
                        'default' => [
                            ['icon' => 'flaticon-telephone-call', 'label' => 'Mobile :', 'value' => Company::PHONE, 'link' => 'tel:' . Company::PHONE],
                            ['icon' => 'flaticon-telephone-call', 'label' => 'Mobile :', 'value' => Company::PHONE_2, 'link' => 'tel:' . Company::PHONE_2],
                            ['icon' => 'flaticon-mail', 'label' => 'Email :', 'value' => Company::EMAIL, 'link' => 'mailto:' . Company::EMAIL],
                            ['icon' => 'flaticon-mail', 'label' => 'Email :', 'value' => Company::EMAIL_2, 'link' => 'mailto:' . Company::EMAIL_2],
                        ],
                    ],
                ],
            ],

            'offices' => [
                'name' => 'Offices',
                'description' => 'Office / branch information cards.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Visit Us'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Our Office'],
                ],
                'repeaters' => [
                    'items' => [
                        'label' => 'Offices',
                        'item_label' => 'Office',
                        'fields' => [
                            'name' => ['label' => 'Office Name', 'type' => 'text'],
                            'address' => ['label' => 'Address', 'type' => 'textarea'],
                            'phone' => ['label' => 'Phone(s)', 'type' => 'text', 'help' => 'Separate several numbers with commas.'],
                            'email' => ['label' => 'Email(s)', 'type' => 'text', 'help' => 'Separate several addresses with commas.'],
                            'hours' => ['label' => 'Opening Hours', 'type' => 'text'],
                        ],
                        'default' => [
                            ['name' => 'Head Office', 'address' => Company::ADDRESS, 'phone' => Company::PHONE . ', ' . Company::PHONE_2, 'email' => Company::EMAIL . ', ' . Company::EMAIL_2, 'hours' => ''],
                        ],
                    ],
                ],
            ],

            'map' => [
                'name' => 'Google Map',
                'description' => 'Full-width map below the form.',
                'fields' => [
                    'embed' => [
                        'label' => 'Google Maps Embed URL or <iframe> Code',
                        'type' => 'textarea',
                        'default' => Company::MAP_EMBED,
                        'help' => 'Google Maps > Share > Embed a map. Paste the whole <iframe> code or just its src URL.',
                    ],
                ],
            ],
        ];
    }
}
