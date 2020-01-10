@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l">Edit catalogue entry</h1>

@include ('partials.errors')

<form action="/entries/{{ $entry->id }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">

    @component('components.text-input', [
        'name' => 'name',
        'label' => 'Name',
        'width' => 'govuk-!-width-one-half',
        'value' => $entry->name
    ])
    @endcomponent

    @component('components.text-input', [
        'name' => 'version',
        'label' => 'Version',
        'width' => 'govuk-!-width-one-quarter',
        'value' => $entry->version
    ])
    @endcomponent

    @component('components.text-input', [
        'name' => 'description',
        'label' => 'Description',
        'value' => $entry->description
    ])
    @endcomponent

    @component('components.text-input', [
        'name' => 'href',
        'label' => 'Vendor URL',
        'value' => $entry->href
    ])
    @endcomponent

    @component('components.text-input', [
        'name' => 'category',
        'label' => 'Category',
        'width' => 'govuk-!-width-one-half',
        'value' => $entry->category
    ])
    @endcomponent

    @component('components.text-input', [
        'name' => 'sub_category',
        'label' => 'Sub category',
        'width' => 'govuk-!-width-one-half',
        'value' => $entry->sub_category
    ])
    @endcomponent

    @component('components.select', [
        'name' => 'status',
        'label' => 'Status',
        'values' => $statuses,
        'value' => $entry->status
    ])
    @endcomponent

    @component('components.textarea', [
        'name' => 'functionality',
        'label' => 'Supported functionality',
        'value' => $entry->functionality
    ])
    @endcomponent

    @component('components.textarea', [
        'name' => 'service_levels',
        'label' => 'Service levels',
        'value' => $entry->service_levels
    ])
    @endcomponent

    @component('components.textarea', [
        'name' => 'interfaces',
        'label' => 'Interfaces',
        'value' => $entry->interfaces
    ])
    @endcomponent

    <!-- related sbbs will be updated in a different way -->

  <button class="govuk-button govuk-!-margin-right-1" data-module="govuk-button" type="submit">
    Save changes
  </button>
  <a class="govuk-button govuk-button--secondary" data-module="govuk-button" href="/entries/{{ $entry->id }}">
    Cancel
  </a>
</form>
@endsection
