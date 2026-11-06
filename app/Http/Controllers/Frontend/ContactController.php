<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\QuoteRequest;
use App\Models\NewsletterSubscriber;
use App\Support\PageSections;
use App\Support\SectionData;
use App\Support\Seo;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Contact page (Slaze contact-two.html), managed in Admin > Contact Page CMS.
     */
    public function index()
    {
        $page = 'contact';
        $settings = PageSections::settings($page);
        $sections = PageSections::visible($page);
        $data = SectionData::load($page, $sections);
        $seo = Seo::page($page);

        return view('frontend.contact.show', compact('page', 'settings', 'sections', 'data', 'seo'));
    }

    /**
     * Store a contact message (contact page and team member pages).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'website' => ['nullable', 'max:0'], // honeypot: real visitors never fill it
        ], [
            'website.max' => 'Your message could not be sent.',
        ]);

        unset($validated['website']);

        ContactMessage::create($validated + [
            'subject' => ($validated['subject'] ?? null) ?: 'Website enquiry',
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
            'status' => 'new',
        ]);

        $contact = PageSections::sections('contact')->firstWhere('section_key', 'contact');
        $message = $contact?->content['success_message'] ?: 'Thank you for contacting us! We will get back to you soon.';

        return redirect()->to(url()->previous() . '#contact-form')->with('contact_success', $message);
    }

    /**
     * Display the quote request form.
     */
    public function quote()
    {
        return view('frontend.quote');
    }

    /**
     * Store a quote request.
     */
    public function storeQuote(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'service' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        QuoteRequest::create($validated);

        return redirect()->back()->with('success', 'Thank you for your quote request! We will contact you shortly.');
    }

    /**
     * Subscribe to newsletter.
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:newsletter_subscribers,email'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        NewsletterSubscriber::create($validated + [
            'status' => 'subscribed',
            'subscribed_at' => now(),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}
