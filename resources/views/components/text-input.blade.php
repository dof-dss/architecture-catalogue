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
        <input class="govuk-input {{ $width ?? '' }} govuk-input--error" id="{{ $name }}" name="{{ $name }}" type="{{ $type ?? 'text' }}" value="{{ old($name) }}" autocomplete="{{ $autocomplete ?? '' }}">
    </div>
@else
    <div class="govuk-form-group">
        <label class="govuk-label" for="{{ $name }}">
          {{ $label }}
        </label>
        @if ( isset($hint) )
            <span id="event-name-hint" class="govuk-hint">
                {{ $hint }}
            </span>
        @endif
        <input class="govuk-input {{ $width ?? '' }}" id="{{ $name }}" name="{{ $name }}" type="{{ $type ?? 'text' }}"
          value="{{ $value ?? old($name) }}" autocomplete="{{ $autocomplete ?? '' }}">
    </div>
@enderror
