@extends('layouts.base')

@section('back')
<a href="/entries/{{ $entry->id }}/links" class="govuk-back-link">Back to entry dependencies</a>
@endsection

@section('content')
<h1 class="govuk-heading-l">Add {{ $entry->name }} {{ $entry->version ? ' (' . $entry->version . ')' : '' }} dependency</h1>
<h2 class="govuk-heading-m">Search catalogue</h2>
<form action="/entries/{{ $entry->id }}/links/search" method="get">
    {{ csrf_field() }}

    <input type="hidden" name="entry_id" value="{{ $entry->id }}">

    @component('components.text-input', [
        'name' => 'phrase',
        'label' => 'Enter a word or phrase to search for in the catalogue',
        'width' => 'govuk-!-width-two-thirds',
        'autofocus' => true
    ])
    @endcomponent

    <button class="govuk-button govuk-!-margin-right-2" type="submit">Continue</button>
</form>
@endsection
