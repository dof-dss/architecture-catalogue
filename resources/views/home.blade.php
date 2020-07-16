@extends('layouts.base')

@section('content')
<div class="">
    <h1 class="govuk-heading-xl">
      Architecture Catalogue
    </h1>
    <p class="govuk-body-l">
        The architecture catalogue is a register of the technical components used by the NICS to build digital services. The catalogue should be used by architects and developers when designing digital solutions for the NICS.
    </p>
    <p class="govuk-body">
        The catalouge currently contains <span class="govuk-!-font-size-24">{{ $entry_count }}</span> entries.
    </p>
    <p class="govuk-body">
      If a component is not listed in the catalogue then it is not considered suitable for use in NICS solutions. If you believe the component should be included in the catalogue then please ask a user with the <i>contributor</i> role to add it for you or <a href="mailto:ea-team@ea.finance-ni.gov.uk" class = "govuk-link">contact the EA Team</a>. In this way the catalogue will grow to provide a comprehensive technology reference for the NICS.
    </p>
    <p class="govuk-body">
        Each entry has a status associated with it, which will determine whether or not it should form part of your solution architecture.
    </p>
    <table class="govuk-table">
        <thead class="govuk-table__head">
            <tr class="govuk-table__row">
                <th scope="col" class="govuk-table__header">Status</th>
                <th scope="col" class="govuk-table__header">Description</th>
            </tr>
        </thead>
        <tbody class="govuk-table__body">
            <tr class="govuk-table__row">
                <td class="govuk-table__cell">
                  <strong class="label label--blue">evaluating</strong>
                </td>
                <td class="govuk-table__cell">Currently being considered for inclusion.</td>
            </tr>
            <tr class="govuk-table__row">
                <td class="govuk-table__cell">
                  <strong class="label label--green">approved</strong>
                </td>
                <td class="govuk-table__cell">Approved for use.</td>
            </tr>
            <tr class="govuk-table__row">
                <td class="govuk-table__cell">
                    <strong class="label label--black">unapproved</strong>
                </td>
                <td class="govuk-table__cell">Requires a dispensation from the architecture board in order to be used.</td>
            </tr>
            <tr class="govuk-table__row">
                <td class="govuk-table__cell">
                    <strong class="label label--red">prohibited</strong>
                </td>
                <td class="govuk-table__cell">Must not be used under any circumstances.</td>
            </tr>
            <tr class="govuk-table__row">
                <td class="govuk-table__cell">
                    <strong class="label label--orange">retiring</strong>
                </td>
                <td class="govuk-table__cell">This component is being retired from use. You should plan to remove it from existing solutions.</td>
            </tr>
        </tbody>
    </table>
    <a class="govuk-button" data-module="govuk-button govuk-!-margin-right-1" href="{{ route('entry.find') }}">
        Find an entry
    </a>
    @if (auth()->user()->isContributor())
        <a class="govuk-button govuk-button--secondary" data-module="govuk-button" href="{{ route('entry.create') }}">
            Add a new entry
        </a>
    @endif
</div>
@endsection
