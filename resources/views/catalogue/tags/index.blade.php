@extends('layouts.base')

@section('back')
<a href="/entries/{{ $entry->id }}" class="govuk-back-link">Back to catalogue entry</a>
@endsection

@section('content')
<h1 class="govuk-heading-l">User defined tags for {{ $entry->name }} {{ $entry->version ? $entry->version : '' }}</h1>

@if ($entry->tags->count() > 0)
    <table class="govuk-table">
        <thead class="govuk-table__head">
            <tr class="govuk-table__row">
                <th scope="col" class="govuk-table__header govuk-!-width-one-quarter">Tag</th>
                <th scope="col" class="govuk-table__header">Action</th>
            </tr>
        </thead>
        <tbody class="govuk-table__body">
            @foreach ($entry->tags->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE) as $tag)
                <tr scope="row" class="govuk-table__row">
                    <td class="govuk-table__cell"><span class="label label--white">{{ $tag->name }}</span></td>
                    <td class="govuk-table__cell">
                        <form method="POST" id="delete-{{ $loop->iteration }}" action="/entries/{{ $entry->id }}/tags/{{ $tag->id }}">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <a class="govuk-link" href="javascript:{}" onclick="document.getElementById('delete-{{ $loop->iteration }}').submit();">Remove</a>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="govuk-warning-text">
        <span class="govuk-warning-text__icon" aria-hidden="true">!</span>
        <strong class="govuk-warning-text__text">
            <span class="govuk-warning-text__assistive">Warning</span>
            There are no tags.
        </strong>
    </div>
@endif

<hr class="govuk-section-break govuk-section-break--m">

<h2 class="govuk-heading-m govuk-!-margin-top-3">Add more tags</h2>

@include ('partials.errors')

@error('tag_id')
    <div class="govuk-form-group govuk-form-group--error">
        <span id="tag-error" class="govuk-error-message">
            <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <form action="/entries/{{ $entry->id }}/tags" method="post">
            {{ csrf_field() }}
            <input name="entry_id" value="{{ $entry->id }}" hidden>
            <span id="event-name-hint" class="govuk-hint">
                Choose an existing tag
            </span>
            <select class="govuk-select govuk-input--error govuk-!-width-one-quarter govuk-!-margin-right-2" id="tag_id" name="tag_id">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" {{ (old('tag_id') == $tag->id) ? 'selected' : '' }}>{{ $tag->name }}</option>
                @endforeach
            </select>
            <button class="govuk-button" type="submit">Add existing tag</button>
        </form>
    </div>
@else
    <div class="govuk-form-group">
        <form action="/entries/{{ $entry->id }}/tags" method="post">
            {{ csrf_field() }}
            <input name="entry_id" value="{{ $entry->id }}" hidden>
            <span id="event-name-hint" class="govuk-hint">
                Choose an existing tag
            </span>
            <select class="govuk-select govuk-!-width-one-quarter govuk-!-margin-right-2" id="tag_id" name="tag_id">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            <button class="govuk-button" type="submit">Add an existing tag</button>
        </form>
    </div>
@endif

@error('new_tag')
    <div class="govuk-form-group govuk-form-group--error">
        <span id="new_tag-error" class="govuk-error-message">
            <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <div class="govuk-form-group">
            <form action="/tags" method="post">
                {{ csrf_field() }}
                <input name="entry_id" value="{{ $entry->id }}" hidden>
                <span id="event-name-hint" class="govuk-hint">
                    Enter a new tag
                </span>
                <input class="govuk-input govuk-input--error govuk-!-width-one-quarter govuk-!-margin-right-2" id="new_tag" name="new_tag" type="text" value="{{ old('new_tag') }}" autocomplete>
                <button class="govuk-button govuk-button--secondary" type="submit">Create and add a tag</button>
            </form>
        </div>
    </div>
@else
    <div class="govuk-form-group">
        <form action="/tags" method="post">
            {{ csrf_field() }}
            <input name="entry_id" value="{{ $entry->id }}" hidden>
            <span id="event-name-hint" class="govuk-hint">
                Enter a new tag
            </span>
            <input class="govuk-input govuk-!-width-one-quarter govuk-!-margin-right-2" id="new_tag" name="new_tag" type="text" autocomplete>
            <button class="govuk-button govuk-button--secondary" type="submit">Create and add a tag</button>
        </form>
    </div>
@endif

@endsection
