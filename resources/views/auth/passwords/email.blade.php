@extends('layouts.base')

@section('content')
<div class="govuk-width-container">
    <main class="govuk-main-wrapper" id="main-content" role="main">
        <!-- we've returned here after a succesful password reset request -->
        @if (session('status'))
            <div class="govuk-panel govuk-panel--confirmation">
                <h1 class="govuk-panel__title">
                    Password reset request complete
                </h1>
                <div class="govuk-panel__body">
                    {{ session('status') }}
                </div>
            </div>
            <h2 class="govuk-heading-m">What happens next</h2>
            <p class="govuk-body">Follow the instructions in your e-mail to reset your password.</p>
        @else
            <h1 class="govuk-heading-l">Reset your password</h1>

            @include ('partials.errors')
            <form method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                @component('components.text-input', [
                    'type' => 'email',
                    'name' => 'email',
                    'label' => 'Enter your e-mail address',
                    'hint' => 'An email will be sent to this address with a password reset link',
                    'width' => 'govuk-!-width-two-thirds'
                ])
                @endcomponent

                <button class="govuk-button" data-module="govuk-button" type="submit">Continue</button>
            </form>
        @endif
    </main>
</div>
@endsection
