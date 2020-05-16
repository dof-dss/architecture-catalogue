<!--
  *
  * Checkbox component using GOV.UK styling and pattern
  *
-->
@error($name)
    <div class="govuk-form-group govuk-form-group--error">
        <span id="{{ $name }}-error" class="govuk-error-message">
          <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <div class="govuk-checkboxes__item">
            <input class="govuk-checkboxes__input" id="{{ $id }}" name="{{ $name }}" type="checkbox" value="{{ $value ?? old($name) }}" checked>
            <label class="govuk-label govuk-checkboxes__label" for="{{ $name }}">
                {{ $label }}
                <span class="{{ $secondary_label_class ?? '' }}">{{ $secondary_label ?? '' }}</span>
            </label>
        </div>
    </div>
@else
    <div class="govuk-checkboxes__item">
        <input class="govuk-checkboxes__input" id="{{ $id }}" name="{{ $name }}" type="checkbox" value="{{ $value ?? old($name) }}">
        <label class="govuk-label govuk-checkboxes__label" for="{{ $name }}">
            {{ $label }}
            <span class="{{ $secondary_label_class ?? '' }}">{{ $secondary_label ?? '' }}</span>
        </label>
    </div>
@enderror
