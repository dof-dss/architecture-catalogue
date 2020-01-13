@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l filter-heading">Browse catalogue</h1>

<div class="govuk-grid-row">
    <div class="govuk-grid-column-full">
        <form method="get" action="/entries" class="filter-section">
            {{ csrf_field() }}
            <table class="govuk-table filter-filters">
                <tbody class="govuk-table__body">
                    <tr class="govuk-table__row">
                        <th class="govuk-table__header" scope="column">
                          Status
                        </th>
                        <th class="govuk-table__header govuk-visually-hidden" scope="column">
                          Filter
                        </th>
                    </tr>
                    <tr>
                        <td class="govuk-table__cell">
                            <!-- custom version of the component to include the blank entry -->
                            @component('components.select', [
                                'name' => 'status',
                                'values' => $statuses,
                                'blank' => true,
                                'width' => 'govuk-!-width-one-half',
                                'value' => $status
                            ])
                            @endcomponent
                        </td>
                        <td class="govuk-table__cell filter-button">
                            <button data-prevent-double-click="true" class="govuk-button" data-module="govuk-button" type="submit">
                                Filter
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>

@if ($entries->count() > 0)
    @include('partials.entries-table')
@else
    <div class="govuk-warning-text">
        <span class="govuk-warning-text__icon" aria-hidden="true">!</span>
        <strong class="govuk-warning-text__text">
            <span class="govuk-warning-text__assistive">Warning</span>
            There are no entries in the catalogue.
        </strong>
    </div>
@endif
<a class="govuk-button" data-module="govuk-button" href="/entries/create">
    Add a new catalogue entry
</a>
@endsection
