@extends('layouts.base')

@section('breadcrumbs')
<div class="govuk-breadcrumbs">
    <ol class="govuk-breadcrumbs__list">
        <li class="govuk-breadcrumbs__list-item">
            <a class="govuk-breadcrumbs__link" href="/home">Home</a>
        </li>
        <li class="govuk-breadcrumbs__list-item">
            <a class="govuk-breadcrumbs__link" href="/tokens">API tokens</a>
        </li>
        <li class="govuk-breadcrumbs__list-item">
            <a class="govuk-breadcrumbs__link">Create token</a>
        </li>
    </ol>
</div>
@endsection

@section('content')

@include ('partials.errors')

<div class="govuk-grid-row">
    <div class="govuk-grid-column-three-quarters">
        <h1 class="govuk-heading-l filter-heading">Create personal access token</h1>

        <form action="/tokens" method="post">
            {{ csrf_field() }}

            @component('components.text-input', [
                'name' => 'name',
                'label' => 'Name for this token',
                'width' => 'govuk-!-width-one-half'
            ])
            @endcomponent

            <button class="govuk-button govuk-!-margin-right-1" data-module="govuk-button" type="submit">
                Continue
            </button>
        </form>
    </div>
</div>
@endsection
