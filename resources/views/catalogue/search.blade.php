@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l">Search catalogue</h1>

<form action="/catalogue/search" method="get">
    {{ csrf_field() }}

    @component('components.text-input', [
        'name' => 'phrase',
        'label' => 'Enter a word or phrase to search for in the catalogue',
        'width' => 'govuk-!-width-three-quarters',
    ])
    @endcomponent

    <button class="govuk-button govuk-!-margin-right-2" type="submit">Continue</button>
</form>
@endsection
