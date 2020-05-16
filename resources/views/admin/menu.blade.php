@extends('layouts.base')

@section('content')

@if (session()->has('status'))
    <div class="govuk-panel govuk-panel--confirmation govuk-!-margin-bottom-5">
        <h1 class="govuk-panel__title">
            Catalogue index created
        </h1>
        <div class="govuk-panel__body">
            Your request to index the catalogue was {{ session()->get('status') }}
        </div>
    </div>
@endif

<h2 class="govuk-heading-l">User administation</h2>

<a class="govuk-link" data-module="govuk-button" href="/users">
    View and manage users
</a>

<hr class="govuk-section-break govuk-section-break--xl govuk-section-break--visible">

<h2 class="govuk-heading-l">Catalogue administation</h2>

<h3 class="govuk-heading-m">Catalogue data</h3>
<p class="govuk-body">Catalogue data will be exported in JSON format.</p>
<a class="govuk-button govuk-!-margin-right-2" data-module="govuk-button" href="/catalogue/export">
    Export catalogue
</a>
<!-- only show features in local development -->
@if (env('APP_ENV') == 'local')
    <a class="govuk-button govuk-button--secondary govuk-!-margin-right-2" data-module="govuk-button" href="/catalogue/upload">
        Import catalogue
    </a>
    <a class="govuk-button govuk-button--warning govuk-!-margin-right-2" data-module="govuk-button" href="/catalogue/delete">
        Delete all entries
    </a>
@endif

<h3 class="govuk-heading-m">Indexing</h3>
<div class="govuk-warning-text">
    <span class="govuk-warning-text__icon" aria-hidden="true">!</span>
    <span class="govuk-warning-text__text">
        <span class="govuk-warning-text__assistive">Warning</span>
        Building and re-building indexes may take some time and will depend on the size of the catalogue.
    </span>
</div>
<a class="govuk-button govuk-button--secondary govuk-!-margin-right-2" data-module="govuk-button" href="/catalogue/index">
    Build index
</a>
<a class="govuk-button govuk-button--warning govuk-!-margin-right-2" data-module="govuk-button" href="/catalogue/reindex">
    Re-build index
</a>
@endsection
