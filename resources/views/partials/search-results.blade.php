<form method="get" action="{{ url()->current() }}">
    <input type="hidden" name="phrase" value="{{ $phrase }}">
    <input type="hidden" name="sort" value="{{ $sort }}">
    <input type="hidden" name="order" value="{{ $order == 'asc' ? 'desc' : 'asc' }}">
    <table class="govuk-table search-results">
        <!-- <caption class="govuk-table__caption govuk-!-margin-bottom-2">This catalogue contains {{ $catalogue_size }} entries.</caption> -->
        <thead class="govuk-table__head">
            <tr class="govuk-table__row">
                <th scope="col" class="govuk-table__header govuk-!-width-one-quarter">
                    <button type="submit" name="sort" value="name_version" class="govuk-button filter-header {{ $sort == 'name_version' ? $order : ''}}">
                        Name (version)
                    </button>
                </th>
                <th scope="col" class="govuk-table__header">
                    <button type="submit" name="sort" value="description" class="govuk-button filter-header {{ $sort == 'description' ? $order : ''}}">
                        Description
                    </button>
                </th>
                <th scope="col" class="govuk-table__header">
                    <button type="submit" name="sort" value="status" class="govuk-button filter-header {{ $sort == 'status' ? $order : ''}}">
                        Status
                    </button>
                </th>
                <th scope="col" class="govuk-table__header">Action</th>
            </tr>
        </thead>
        <tbody class="govuk-table__body">
            @foreach ($entries as $entry)
                <tr scope="row" class="govuk-table__row">
                    <td class="govuk-table__cell">{{ $entry->name }} {{ $entry->version ? '(' . $entry->version . ')' : '' }}</td>
                    <td class="govuk-table__cell">{{ $entry->description }}</td>
                    <td class="govuk-table__cell">
                        <span class="{{ $labels[$entry->status] }}">{{ $entry->status }}</span>
                    </td>
                    <td class="govuk-table__cell">
                        <a
                            class="govuk-link"
                            href="/entries/{{ $entry->id }}?path={{ urlencode(url()->full()) }}">
                            View
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</form>
{{ $entries->links() }}
@if ( auth()->user()->isContributor())
    <a class="govuk-button" data-module="govuk-button" href="/entries/create">
        Add a new catalogue entry
    </a>
@endif
