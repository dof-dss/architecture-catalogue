@extends('layouts.base')

@section('back')
<a href="/users/{{ $user->id }}/edit" class="govuk-back-link">See user view</a>
@endsection

@section('content')
<div class="govuk-grid-row">
    <div class="govuk-grid-column-three-quarters">
        <h2 class="govuk-heading-l">Are you sure you'd like to remove the following user?</h2>
        <p class="govuk-heading-m">{{ $user->email }}</p>
        <form action="/users/{{ $user->id }}" method="POST" class="govuk-!-mt-r6 paas-remove-user">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="govuk-button govuk-button--warning" data-module="govuk-button" type="submit">Yes, remove this user</button>
            <a class="govuk-link" href="/users/{{ $user->id }}/edit">No, go back to user view</a>
        </form>
    </div>
</div>
@endsection
