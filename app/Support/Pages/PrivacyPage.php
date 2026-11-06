<?php

namespace App\Support\Pages;

use App\Support\Company;

class PrivacyPage extends LegalPage
{
    protected static function title(): string
    {
        return 'Privacy Policy';
    }

    protected static function route(): string
    {
        return 'privacy';
    }

    protected static function body(): string
    {
        $email = Company::EMAIL;
        $phone = Company::PHONE;
        $address = Company::ADDRESS;

        return <<<TXT
This Privacy Policy explains how Si Green Energy ("we", "us") collects and uses personal information when you visit our website or contact us.

Information we collect

When you send us a message through our contact form, we collect the details you provide: your name, email address, phone number (optional), subject and message. When you subscribe to our newsletter, we collect your email address.

Like most websites, our server also records technical information such as your IP address, browser type and the pages you visit. The contact form records your IP address and browser information to help us protect the website against spam and misuse.

How we use your information

We use the information you provide to respond to your enquiry, prepare quotations and proposals, provide our services, and send you updates you have asked for. We do not sell or rent your personal information to third parties.

Cookies

Our website uses essential cookies that are required for it to work, for example to keep forms secure. Embedded content such as maps may set their own cookies under the policies of their providers.

How long we keep information

We keep enquiry and customer information for as long as it is needed for the purposes described above, or as required by law.

Your choices

You may ask us to access, correct or delete the personal information we hold about you, or to stop sending you newsletters, by contacting us using the details below.

Contact us

Si Green Energy
{$address}
Email: {$email}
Phone: {$phone}

Changes to this policy

We may update this Privacy Policy from time to time. The latest version will always be available on this page.
TXT;
    }
}
