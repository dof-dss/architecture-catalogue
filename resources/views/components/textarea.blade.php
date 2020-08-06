<!--
  *
  * Text area component using GOV.UK styling and pattern
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
        <textarea class="govuk-textarea govuk-input--error" id="{{ $name }}" name="{{ $name }}" rows="{{ $rows ?? 5}}">{{ old($name) }}
        </textarea>
    </div>
@else
    <div class="govuk-form-group">
        <label class="govuk-label" for="{{ $name }}">
            {{ $label }}
        </label>
        <textarea class="govuk-textarea" id="{{ $name }}" name="{{ $name }}" rows="{{ $rows ?? 5}}">{{ $value ?? old($name) }}</textarea>
    </div>
@enderror
