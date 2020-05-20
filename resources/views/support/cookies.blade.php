@extends('layouts.base')

@section('content')
<div class="govuk-grid-row">
    <div class="govuk-grid-column-three-quarters">
        <h1 class="govuk-heading-xl">Cookies</h1>
        <p class="govuk-body">
            The NICS Architecture Catalogue puts small files (known as ‘cookies’) on to your computer.
        </p>
        <p class="govuk-body">
            We use cookies to:
        </p>
        <ul class="govuk-list govuk-list--bullet">
            <li>
                record the notifications you’ve seen so we do not show them again
            </li>
            <li>
                measure how you use the website so it can be updated and improved based on your activity
            </li>
        </ul>
        <p class="govuk-body">
            You’ll see a message on the site before we store a cookie on your computer.
        </p>
        <p class="govuk-body">
            <a class="govuk-link" href="https://ico.org.uk/for-the-public/online/cookie">Find out how to manage cookies</a>
        </p>

        <h2 class="govuk-heading-l">Our cookie message</h2>
        <p class="govuk-body">
            You will see a message about cookies when you first visit the NICS Architecture Catalogue. We’ll store a cookie so that your computer knows you’ve seen it and knows not to show it again.
        </p>

        <table class="govuk-table app-table--fixed">
            <caption class="govuk-table__caption govuk-visually-hidden">NICS Catalogue Cookies</caption>
            <thead class="govuk-table__head">
                <tr class="govuk-table__row">
                    <th scope="col" class="govuk-table__header">Name</th>
                    <th scope="col" class="govuk-table__header">Purpose</th>
                    <th scope="col" class="govuk-table__header">Expires</th>
                </tr>
            </thead>
            <tbody class="govuk-table__body">
                <tr class="govuk-table__row">
                    <td class="govuk-table__cell">seen_cookie_message</td>
                    <td class="govuk-table__cell">Saves a message to let us know that you have seen our cookie message</td>
                    <td class="govuk-table__cell">28 days</td>
                </tr>
            </tbody>
        </table>

        <h2 class="govuk-heading-l">Measuring website usage with Google Analytics</h2>
        <p class="govuk-body">
            We use Google Analytics software to collect information about how you use the NICS Architecture Catalogue. We do this to help make sure the site is meeting the needs of its users and to help us make improvements.
        </p>
        <p class="govuk-body">
            Google Analytics stores information about:
        </p>
        <ul class="govuk-list govuk-list--bullet">
            <li>
                the pages you visit
            </li>
            <li>
                how long you spend on each page
            </li>
            <li>
                how you got to the site
            </li>
            <li>
                what you click on while you’re visiting the site.
            </li>
        </ul>
        <p class="govuk-body">
            We do not collect or store your personal information, so this data cannot be used to identify who you are. For more information visit our <a class="govuk-link" href="/privacy-policy">privacy policy</a> page.
        </p>
        <p class="govuk-body">
            We do not allow Google to use or share our analytics data.
        </p>
        <p class="govuk-body">
            Google Analytics sets the following cookies:
        </p>
        <table class="govuk-table app-table--fixed">
            <caption class="govuk-table__caption govuk-visually-hidden">Google Analytics cookies</caption>
            <thead class="govuk-table__head">
              <tr class="govuk-table__row">
                <th scope="col" class="govuk-table__header">Name</th>
                <th scope="col" class="govuk-table__header">Purpose</th>
                <th scope="col" class="govuk-table__header">Expires</th>
              </tr>
            </thead>
            <tbody class="govuk-table__body">
                <tr class="govuk-table__row">
                    <td class="govuk-table__cell">_ga</td>
                    <td class="govuk-table__cell">This helps us count how many people visit the NICS Architecture Catalogue by tracking if you’ve visited before</td>
                    <td class="govuk-table__cell">2 years</td>
                </tr>
                <tr class="govuk-table__row">
                    <td class="govuk-table__cell">_gid</td>
                    <td class="govuk-table__cell">This helps us count how many people visit the NICS Architecture Catalogue site by tracking if you’ve visited before</td>
                    <td class="govuk-table__cell">24 hours</td>
                </tr>
                <tr class="govuk-table__row">
                    <td class="govuk-table__cell">_gat</td>
                    <td class="govuk-table__cell">This is used to limit the rate at which page view requests are recorded by Google</td>
                    <td class="govuk-table__cell">1 minute</td>
                  </tr>
            </tbody>
          </table>
    </div>
</div>
@endsection
