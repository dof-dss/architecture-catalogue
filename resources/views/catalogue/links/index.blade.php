@extends('layouts.base')

@section('back')
<a href="/entries/{{ $entry->id }}" class="govuk-back-link">Back to catalogue entry</a>
@endsection

@section('content')
<h1 class="govuk-heading-xl">{{ $entry->name }} {{ $entry->version ? $entry->version : '' }} dependencies</h1>

@if ($entry->children->count() > 0)
    <table class="govuk-table">
        <thead class="govuk-table__head">
            <tr class="govuk-table__row">
                <th scope="col" class="govuk-table__header govuk-!-width-one-quarter">Name</th>
                <th scope="col" class="govuk-table__header">Description</th>
                <th scope="col" class="govuk-table__header">Status</th>
                <th scope="col" class="govuk-table__header">Action</th>
            </tr>
        </thead>
        <tbody class="govuk-table__body">
            @foreach ($entry->children as $link)
                <tr scope="row" class="govuk-table__row">
                    <td class="govuk-table__cell">{{ $link->parent->name }} {{ $link->parent->version ? '(' . $link->parent->version . ')' : '' }}</td>
                    <td class="govuk-table__cell">{{ $link->parent->description }}</td>
                    <td class="govuk-table__cell">
                        <span class="{{ $labels[$link->parent->status] }}">{{ $link->parent->status }}</span>
                    </td>
                    <td class="govuk-table__cell">
                        <form method="POST" id="delete-{{ $loop->iteration }}" action="/entries/{{ $entry->id }}/links/{{ $link->id }}">
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
            There are no dependencies.
        </strong>
    </div>
@endif

<a class="govuk-button" href="/entries/{{ $entry->id }}/links/create">Add dependency</a>
@endsection
