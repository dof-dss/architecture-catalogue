@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l">Search catalogue</h1>
<form action="/catalogue/search" method="get">
    {{ csrf_field() }}

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
        'width' => 'govuk-!-width-one-third',
        'values' => $statuses,
        'blank' => true
    ])
    @endcomponent

    <button class="govuk-button govuk-!-margin-right-2" type="submit">Search</button>
</form>
@endsection
