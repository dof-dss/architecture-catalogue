@extends('layouts.base')

@section('back')
<a href="/entries/{{ $entry->id }}/links" class="govuk-back-link">Back to entry dependencies</a>
@endsection

@section('content')
<h1 class="govuk-heading-xl">Add {{ $entry->name }} dependency</h1>
<h2 class="govuk-heading-l">Search catalogue</h2>
<form action="/entries/{{ $entry->id }}/links/search" method="get">
    {{ csrf_field() }}

    <input type="hidden" name="entry_id" value="{{ $entry->id }}"

    @component('components.text-input', [
        'name' => 'name',
        'label' => 'Enter the name of an entry (e.g. GOV.UK Notify)',
        'width' => 'govuk-!-width-two-thirds'
    ])
    @endcomponent

    @component('components.text-input', [
        'name' => 'description',
        'label' => 'Enter the description of an entry (e.g. Notifications)',
        'width' => 'govuk-!-width-two-thirds'
    ])
    @endcomponent

    <!-- custom version of the component to include the blank entry -->
    @component('components.select', [
        'name' => 'status',
        'label' => 'Status',
        'values' => $statuses,
        'blank' => true
    ])
    @endcomponent

    <button class="govuk-button" type="submit">Search</button>
</form>
@endsection
