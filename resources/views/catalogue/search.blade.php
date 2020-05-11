@extends('layouts.base')

@section('breadcrumbs')
<div class="govuk-breadcrumbs">
    <ol class="govuk-breadcrumbs__list">
        <li class="govuk-breadcrumbs__list-item">
          <a class="govuk-breadcrumbs__link" href="/home">Home</a>
        </li>
        <li class="govuk-breadcrumbs__list-item" aria-current="page">Search</li>
    </ol>
</div>
@endsection

@section('content')
<h1 class="govuk-heading-l">Search catalogue</h1>

<form action="/catalogue/search" method="get">
    {{ csrf_field() }}

    @component('components.text-input', [
        'name' => 'phrase',
        'label' => 'Enter a word or phrase to search for in the catalogue',
        'width' => 'govuk-!-width-three-quarters',
        'autofocus' => true
    ])
    @endcomponent

    <button class="govuk-button govuk-!-margin-right-2" type="submit">Continue</button>
</form>
@endsection
