@if (config('circleci.branch') != 'master')
<div class="govuk-phase-banner">
    <p class="govuk-phase-banner__content">
        <strong class="govuk-tag govuk-tag--red" style="margin: 5px 10px;">Preview</strong>
        <span class="govuk-phase-banner__text">
            This is a preview of <a class="govuk-link" href="{{ config('circleci.pull_request') }}">{{ config('circleci.branch') }}</a> pull request.
        </span>
    </p>
</div>
@endif
