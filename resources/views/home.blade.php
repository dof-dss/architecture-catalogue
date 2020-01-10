@extends('layouts.base')

@section('content')
<div class="">
    <h1 class="govuk-heading-xl">Architecture Catalogue</h1>
    <p class="govuk-body">
      This architecture catalogue contains all of the solution building blocks (physical components) used by the NICS. This list is used to populate the NICS Architecture Portal which provides a publically accessible reference for architects designing solutions for the NICS.
    </p>
    <a class="govuk-button" data-module="govuk-button" href="/entries/create">
        Add a new catalogue entry
    </a>
</div>

<!-- only show features in local development -->
@if (env('APP_ENV') == 'local')
    <hr class="govuk-section-break govuk-section-break--l govuk-section-break--visible">
    <h2 class="govuk-heading-l">Administration</h2>
    <a class="govuk-button govuk-button--secondary govuk-!-margin-right-2" data-module="govuk-button" href="/catalogue/export">
      Export catalogue
    </a>
    <a class="govuk-button govuk-button--secondary govuk-!-margin-right-2" data-module="govuk-button" href="/catalogue/upload">
      Import catalogue
    </a>
    <a class="govuk-button govuk-button--warning govuk-!-margin-right-2" data-module="govuk-button" href="/catalogue/delete">
      Delete catalogue
    </a>
@endif
@endsection
