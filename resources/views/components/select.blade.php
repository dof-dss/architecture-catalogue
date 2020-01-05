<!--
  *
  * Select component using GOV.UK styling and pattern
  *
-->
@error($name)
    <div class="govuk-form-group govuk-form-group-error">
        <label class="govuk-label" for="{{ $name }}">
            {{ $label }}
        </label>
        <span id="{{ $name }}-error" class="govuk-error-message">
            <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <select class="govuk-select govuk-input--error" id="{{ $name }}" name="{{ $name }}">
        @foreach ($values as $value)
            <option value="{{ $value }}">{{ $value }}</option>
        @endforeach
        </select>
    </div>
@else
    <div class="govuk-form-group">
        <label class="govuk-label" for="{{ $name }}">
            {{ $label }}
        </label>
        <select class="govuk-select" id="{{ $name }}" name="{{ $name }}">
          @foreach ($values as $value)
              <option value="{{ $value }}">{{ $value }}</option>
          @endforeach
        </select>
    </div>
@enderror
