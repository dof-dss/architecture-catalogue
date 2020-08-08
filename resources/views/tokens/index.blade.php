@extends('layouts.base')

@section('breadcrumbs')
<div class="govuk-breadcrumbs">
    <ol class="govuk-breadcrumbs__list">
        <li class="govuk-breadcrumbs__list-item">
            <a class="govuk-breadcrumbs__link" href="/home">Home</a>
        </li>
        <li class="govuk-breadcrumbs__list-item">
            <a class="govuk-breadcrumbs__link">API tokens</a>
        </li>
    </ol>
</div>
@endsection

@section('content')
<div class="govuk-grid-row">
    <div class="govuk-grid-column-three-quarters">
        <h1 class="govuk-heading-l filter-heading">API integration</h1>
        <p class="govuk-body">
            You can also get read only access to this catalogue using the API published on our <a class="govuk-link" href="https://developer-portal.ea.digitalni.gov.uk">developer portal</a>.
        </p>
        <p class="govuk-body">
           When you make an API request to the catalogue you must pass a personal access token in the Authorization header as a Bearer token. When you create a  token you will have one opportunity only to note its value, the value you see subsequently is a hashed value.
        </p>
        <p class="govuk-body">
            To find out more about this API by please view the <a href="/api/documentation" class="govuk-link">OpenApi documentation</a>.
        </p>
        <h2 class="govuk-heading-m filter-heading">Personal Access Tokens</h2>
        @if ($user->tokens->count() > 0)
            <div class="govuk-grid-column-full">
                <table class="govuk-table filter-table">
                    <thead class="govuk-table__head">
                        <tr class="govuk-table__row">
                            <th scope="col" class="govuk-table__header">Name</th>
                            <th scope="col" class="govuk-table__header">Value</th>
                            <th scope="col" class="govuk-table__header">Action</th>
                        </tr>
                    </thead>
                    <tbody class="govuk-table__body">
                        @foreach ($user->tokens as $personal_access_token)
                            <tr scope="row" class="govuk-table__row">
                                <td class="govuk-table__cell">{{ $personal_access_token->name }}</td>
                                <td class="govuk-table__cell">{{ Str::limit($personal_access_token->token, 10, '***') }}</td>
                                <td class="govuk-table__cell">
                                    <a class="govuk-link" href="/tokens/{{ $personal_access_token->id }}/revoke">Revoke</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="govuk-body">
                You have not created any personal access tokens.
            </p>
        @endif
        <a class="govuk-button" data-module="govuk-button" href="/tokens/create">
            Create a personal access token
        </a>
    </div>
</div>
@endsection
