@extends('layouts.base')

@section('content')

@include ('partials.errors')

<div class="govuk-grid-row">
    <div class="govuk-grid-column-three-quarters">
        <h2 class="govuk-heading-l">Use single sign-on</h2>
        <h3 class="govuk-heading-m">NICS Identity Hub</h3>
        <p class="govuk-body">
            The NICS Identity Hub supports the following identity providers:
        </p>
        <details class="govuk-details" data-module="govuk-details">
            <summary class="govuk-details__summary">
                <span class="govuk-details__summary-text">
                    Application identity
                </span>
            </summary>
            <div class="govuk-details__text">
                You create and use an account specifically for this application.
            </div>
        </details>
        <details class="govuk-details" data-module="govuk-details">
            <summary class="govuk-details__summary">
                <span class="govuk-details__summary-text">
                    Microsoft corporate identity
                </span>
            </summary>
            <div class="govuk-details__text">
                You use an existing NICS Active Directory account. This option is open to NICS staff on the nigov domain that are connected to the NICS network.
            </div>
        </details>
        <a class="govuk-button govuk-button--secondary" href="/login/cognito">Continue</a>
    </div>
</div>

@endsection
