@extends('layouts.base')

@section('content')
<div class="govuk-grid-row">
    <div class="govuk-grid-column-two-thirds">
        <h1 class="govuk-heading-xl">Authorisation required</h1>
        <p class="govuk-body">
            You are not permitted to perform the requested action.
        </p>
        <p class="govuk-body">
            If you typed the web address, check it is correct.
        </p>
        <p class="govuk-body">
            If you pasted the web address, check you copied the entire address.
        </p>
        <p class="govuk-body">
            If the web address is correct or you selected a link or button, <a href="mailto:ea-team@ea.finance-ni.gov.uk" class="govuk-link">contact the EA Team</a> if you need to report an issue with the catalogue.
        </p>
    </div>
</div>
@endsection
