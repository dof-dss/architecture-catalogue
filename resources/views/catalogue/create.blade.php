@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l">New catalogue entry</h1>

@include ('partials.errors')

<form action="/entries" method="post">
    {{ csrf_field() }}

    <h2 class="govuk-heading-m">Core information</h2>

    @component('components.text-input', [
        'name' => 'name',
        'label' => 'Name',
        'width' => 'govuk-!-width-one-half'
    ])
    @endcomponent

    @component('components.text-input', [
        'name' => 'version',
        'label' => 'Version',
        'width' => 'govuk-!-width-one-quarter'
    ])
    @endcomponent

    @component('components.textarea', [
        'name' => 'description',
        'label' => 'Description',
        'rows' => 2
    ])
    @endcomponent

    @component('components.text-input', [
        'name' => 'href',
        'label' => 'Associated URL'
    ])
    @endcomponent

    @component('components.group-select', [
        'name' => 'category_subcategory',
        'label' => 'Category and sub-category',
        'width' => 'govuk-!-width-one-half',
        'values' => $categories,
        'blank' => true
    ])
    @endcomponent

    @component('components.select', [
        'name' => 'status',
        'label' => 'Status',
        'width' => 'govuk-!-width-one-half',
        'values' => $statuses,
        'blank' => true
    ])
    @endcomponent

    <h2 class="govuk-heading-m">Additional information</h2>

    @component('components.textarea', [
        'name' => 'functionality',
        'label' => 'Supported functionality'
    ])
    @endcomponent

    @component('components.textarea', [
        'name' => 'service_levels',
        'label' => 'Service levels'
    ])
    @endcomponent

    @component('components.textarea', [
        'name' => 'interfaces',
        'label' => 'Interfaces'
    ])
    @endcomponent

    <!-- related sbbs will be captured in a different way once the main entry is created -->

    <button class="govuk-button govuk-!-margin-right-1" data-module="govuk-button" type="submit">
      Save new entry
    </button>
    <a class="govuk-button govuk-button--secondary" data-module="govuk-button" href="{{ url()->previous() }}">
      Cancel
    </a>
</form>
@endsection
