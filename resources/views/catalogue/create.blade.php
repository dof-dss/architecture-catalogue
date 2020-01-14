@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l">New catalogue entry</h1>

@include ('partials.errors')

<form action="/entries" method="post">
    {{ csrf_field() }}

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

    @component('components.text-input', [
        'name' => 'description',
        'label' => 'Description'
    ])
    @endcomponent

    @component('components.text-input', [
        'name' => 'href',
        'label' => 'Associated URL'
    ])
    @endcomponent

    @component('components.text-input', [
        'name' => 'category',
        'label' => 'Category',
        'width' => 'govuk-!-width-one-half'
    ])
    @endcomponent

    @component('components.text-input', [
        'name' => 'sub_category',
        'label' => 'Sub category',
        'width' => 'govuk-!-width-one-half'
    ])
    @endcomponent

    @component('components.select', [
        'name' => 'status',
        'label' => 'Status',
        'values' => $statuses,
        'blank' => true
    ])
    @endcomponent

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

    <div class="govuk-form-group">
        <label class="govuk-label">
            Category and sub-category
        </label>
        <select class="govuk-select">
            <option value=""></option>
            @foreach ($categories as $key => $value)
                <optgroup label="{{ $key }}"</optgroup>
                @foreach ($value as $item)
                    <option value="{{ $key }}-{{ $item }}">{{ $item }}</option>
                @endforeach
            @endforeach
        </select>
    </div>

    <!-- related sbbs will be captured in a different way once the main entry is created -->

    <button class="govuk-button govuk-!-margin-right-1" data-module="govuk-button" type="submit">
      Save new entry
    </button>
    <a class="govuk-button govuk-button--secondary" data-module="govuk-button" href="{{ url()->previous() }}">
      Cancel
    </a>
</form>
@endsection
