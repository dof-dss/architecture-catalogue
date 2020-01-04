<table class="govuk-table">
  <caption class="govuk-table__caption govuk-!-margin-bottom-2">This catalogue contains {{ $entries->total() }} entries.</caption>
  <thead class="govuk-table__head">
      <tr class="govuk-table__row">
          <th scope="col" class="govuk-table__header govuk-!-width-one-quarter">Physical component</th>
          <th scope="col" class="govuk-table__header">Description</th>
          <th scope="col" class="govuk-table__header">Status</th>
          <th scope="col" class="govuk-table__header">Action</th>
      </tr>
  </thead>
  <tbody class="govuk-table__body">
      @foreach ($entries as $entry)
          <tr scope="row" class="govuk-table__row">
              @if ($entry->href)
                  <td class="govuk-table__cell">
                      <a class="govuk-link" href="{{ $entry->href }}">
                        {{ $entry->name }} {{ $entry->version ? '(' . $entry->version . ')' : '' }}
                      </a>
                  </td>
              @else
                  <td class="govuk-table__cell">{{ $entry->name }} {{ $entry->version ? '(' . $entry->version . ')' : '' }}</td>
              @endif
              <td class="govuk-table__cell">{{ $entry->description }}</td>
              <td class="govuk-table__cell">
                  <span class="{{ $labels[$entry->status] }}">{{ $entry->status }}</span>
              </td>
              <td class="govuk-table__cell">
                  <a class="govuk-link" href="/entries/{{ $entry->id }}/edit">Edit</a>&nbsp;|&nbsp;
                  <a class="govuk-link" href="/entries/{{ $entry->id }}/copy">Copy</a>
              </td>
          </tr>
      @endforeach
  </tbody>
</table>
{{ $entries->links() }}
