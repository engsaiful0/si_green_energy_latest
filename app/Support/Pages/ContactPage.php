<?php

namespace App\Support\Pages;

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
        return PageSections::pageSettings(true, 'Contact Us', 'Get in touch with SI Green Energy for solar installations, maintenance and quotes.');
    }

    public static function sections(): array
    {
        return [
            'contact' => [
                'name' => 'Contact Form & Details',
                'description' => 'Form headings and texts, contact detail cards and social links.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Contact us'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Do you have any question?'],
                    'text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Tell us about your project or question and our team will get back to you within one business day.'],
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
                            ['icon' => 'flaticon-telephone-call', 'label' => 'Phone :', 'value' => '+125 (895) 658 568', 'link' => 'tel:+125895658568'],
                            ['icon' => 'flaticon-mail', 'label' => 'Email Address :', 'value' => 'info@sigreenenergy.com', 'link' => 'mailto:info@sigreenenergy.com'],
                            ['icon' => 'flaticon-location-1', 'label' => 'Location :', 'value' => 'New Jersey 45463', 'link' => 'https://google.com/maps'],
                            ['icon' => 'flaticon-wall-clock', 'label' => 'Opening Hours :', 'value' => 'Mon-Fri 09 am-05 pm', 'link' => ''],
                        ],
                    ],
                ],
            ],

            'offices' => [
                'name' => 'Offices',
                'description' => 'Office / branch information cards.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Our Offices'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Visit Us'],
                ],
                'repeaters' => [
                    'items' => [
                        'label' => 'Offices',
                        'item_label' => 'Office',
                        'fields' => [
                            'name' => ['label' => 'Office Name', 'type' => 'text'],
                            'address' => ['label' => 'Address', 'type' => 'textarea'],
                            'phone' => ['label' => 'Phone', 'type' => 'text'],
                            'email' => ['label' => 'Email', 'type' => 'text'],
                            'hours' => ['label' => 'Opening Hours', 'type' => 'text'],
                        ],
                        'default' => [
                            ['name' => 'Head Office', 'address' => '2464 Royal Ln. Mesa, New Jersey 45463', 'phone' => '+125 (895) 658 568', 'email' => 'info@sigreenenergy.com', 'hours' => 'Mon-Fri 09 am-05 pm'],
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
                        'default' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.15830894606!2d-74.11976383964463!3d40.69766374865767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1652012644726!5m2!1sen!2sbd',
                        'help' => 'Google Maps > Share > Embed a map. Paste the whole <iframe> code or just its src URL.',
                    ],
                ],
            ],
        ];
    }
}
