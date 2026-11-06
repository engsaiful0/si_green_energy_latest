<?php

namespace App\Support\Pages;

use App\Support\Company;

class TermsPage extends LegalPage
{
    protected static function title(): string
    {
        return 'Terms and Conditions';
    }

    protected static function route(): string
    {
        return 'terms';
    }

    protected static function body(): string
    {
        $email = Company::EMAIL;
        $phone = Company::PHONE;

        return <<<TXT
These Terms and Conditions apply to your use of the Si Green Energy website. By using the website, you agree to these terms.

Information on this website

The information on this website, including descriptions of products, services, solutions and technical topics, is provided for general information. Product specifications, availability and suitability depend on the specific manufacturer, model and project, and should be confirmed in a written quotation or proposal.

Quotations and services

Any quotation, proposal or agreement for products or services is governed by the terms stated in that document. Information on the website does not by itself form an offer or a contract.

Intellectual property

The text, graphics, logos and other content on this website belong to Si Green Energy or are used with permission, and may not be copied or reused without our written consent, except for personal, non-commercial use.

Links to other websites

Our website may link to third-party websites, such as official sources and social media pages. We are not responsible for the content or practices of those websites.

Limitation of liability

We take care to keep the information on this website accurate and up to date, but we do not guarantee that it is complete or error-free. To the extent permitted by law, Si Green Energy is not liable for any loss arising from the use of this website or reliance on its content.

Governing law

These terms are governed by the laws of Bangladesh.

Contact

If you have any questions about these terms, please contact us at {$email} or {$phone}.
TXT;
    }
}
