@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l">Request an account</h1>

@include ('partials.errors')
<form method="POST" action="/admin/user">
    {{ csrf_field() }}

    @component('components.text-input', [
        'name' => 'name',
        'label' => 'Enter your full name',
        'width' => 'govuk-!-width-one-half'
    ])
    @endcomponent

    @component('components.text-input', [
        'type' => 'email',
        'name' => 'email',
        'label' => 'E-mail address',
        'width' => 'govuk-!-width-one-half'
    ])
    @endcomponent

    <button class="govuk-button" data-module="govuk-button" type="submit">Submit</button>
</form>
@endsection
