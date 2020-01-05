<!--
  *
  * Text input component using GOV.UK styling and pattern
  *
-->
@error($name)
    <div class="govuk-form-group govuk-form-group--error">
        <label class="govuk-label" for="{{ $name }}">
          {{ $label }}
        </label>
        <span id="{{ $name }}-error" class="govuk-error-message">
          <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <input class="govuk-input {{ $width }} govuk-input--error" id="{{ $name }}" name="{{ $name }}" type="text" value="{{ old($name) }}">
    </div>
@else
    <div class="govuk-form-group">
        <label class="govuk-label" for="{{ $name }}">
          {{ $label }}
        </label>
        <input class="govuk-input {{ $width ?? '' }}" id="{{ $name }}" name="{{ $name }}" type="text"
          value="{{ $value ?? '' }}">
    </div>
@enderror
