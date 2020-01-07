@extends('layouts.base')

@section('content')
<div class="govuk-width-container">
    <main class="govuk-main-wrapper" id="main-content" role="main">
        <h1 class="govuk-heading-l">Change your password</h1>

        @include ('partials.errors')
        <form method="POST" action="{{ route('password.update') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            @component('components.text-input', [
                'type' => 'email',
                'name' => 'email',
                'label' => 'Enter your e-mail address',
                'hint' => 'An email will be sent to this address with a password reset link',
                'width' => 'govuk-!-width-two-thirds',
                'autocomplete' => 'email'
            ])
            @endcomponent

            @component('components.text-input', [
                'type' => 'password',
                'name' => 'password',
                'label' => 'Create a password',
                'width' => 'govuk-!-width-one-half'
            ])
            @endcomponent

            @component('components.text-input', [
                'type' => 'password',
                'name' => 'password_confirmation',
                'label' => 'Confirm password',
                'width' => 'govuk-!-width-one-half'
            ])
            @endcomponent

            <button class="govuk-button" data-module="govuk-button" type="submit">Continue</button>
        </form>
    </main>
</div>
@endsection
