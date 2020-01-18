@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l">Verify your e-mail address</h1>

@if (session('resent'))
    <div class="govuk-panel govuk-panel--confirmation">
        <h1 class="govuk-panel__title">
          Verfication link sent
        </h1>
        <div class="govuk-panel__body">
          A new verification link has been sent to your e-mail address.
        </div>
    </div>
@endif

<p class="govuk-body">Before proceeding, please check your email for a verification link.</p>
<p class="govuk-body">If you did not receive the email</p>

<form id="login" action="{{ route('verification.resend') }}" method="post">
    {{ csrf_field() }}
    <button class="govuk-button" type="submit">Request another verification link</button>
</form>
@endsection
