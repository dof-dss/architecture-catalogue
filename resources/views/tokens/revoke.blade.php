@extends('layouts.base')

@section('content')
<div class="govuk-grid-row">
    <div class="govuk-grid-column-three-quarters">
        <h2 class="govuk-heading-l">Are you sure you'd like to revoke the following personal access token?</h2>
        <p class="govuk-heading-m">{{ $token->name }}</p>
        <p class="govuk-body">{{ Str::limit($token->token, 10, '***') }}</p>
        <form action="/tokens/{{ $token->id }}" method="POST" class="govuk-!-mt-r6 paas-remove-user">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="govuk-button govuk-button--warning" data-module="govuk-button" type="submit">Yes, revoke this token</button>
            <a class="govuk-link" href="/tokens">No, go back to tokens view</a>
        </form>
    </div>
</div>
@endsection
