@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-xl filter-heading">Administration</h1>

<h2 class="govuk-heading-l">Catalogue</h2>
<a class="govuk-button govuk-button--secondary govuk-!-margin-right-2" data-module="govuk-button" href="/catalogue/export">
    Export catalogue
</a>
<!-- only show features in local development -->
@if (env('APP_ENV') == 'local')
    <a class="govuk-button govuk-button--secondary govuk-!-margin-right-2" data-module="govuk-button" href="/catalogue/upload">
        Import catalogue
    </a>
    <a class="govuk-button govuk-button--warning govuk-!-margin-right-2" data-module="govuk-button" href="/catalogue/delete">
        Delete catalogue
    </a>
@endif
@endsection
