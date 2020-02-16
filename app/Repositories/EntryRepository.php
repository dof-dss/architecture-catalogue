<?php

namespace App\Repositories;

use App\Entry;
use App\Repositories\Interfaces\EntryRepositoryInterface;

use Carbon\Carbon;

class EntryRepository implements EntryRepositoryInterface
{
    /**
     *  Return a specific entry
     *  @param $id
     */
    public function get($id): object
    {
        return Entry::findOrFail($id);
    }

    /**
     *
     */
    public function all(): array
    {
        return array(
            'href' => url()->current(),
            'timestamp' => Carbon::now(),
            'entries' => Entry::all()
        );
    }

    /**
     *  Return entries filtered by the supplied criteria
     *  @param Array $criteria
     *  @return Collection
     */
    public function filter(array $criteria): object
    {
        $entry = (new Entry)->newQuery();
        // search for an entry based on its status
        if (array_key_exists('status', $criteria)) {
            $entry->where('status', $criteria['status']);
        }
        // search for an entry based on its category
        if (array_key_exists('category', $criteria)) {
            $entry->where('category', $criteria['category']);
        }
        // search for an entry based on its sub-category
        if (array_key_exists('sub-category', $criteria)) {
            $entry->where('sub_category', $criteria['sub_category']);
        }
        $page_size = $this->calculatePageSize($entry->count());
        return $entry->orderBy('name')->Paginate($page_size);
    }

    /**
     *  Calculate page size to ensure there is a maximum of 5 pages
     *
     *  @param Integer $num_rows
     *  @return Integer
     */
    public function calculatePageSize($num_rows)
    {
        $page_size = config('app.page_size');
        $num_pages = ceil($num_rows / $page_size);
        if ($num_pages > config('app.max_pages')) {
            $page_size = ceil($num_rows / $num_pages);
        }
        return $page_size;
    }

    /**
     *  Create a new entry
     *
     *  @param array $data
     *  @return int
     */
    public function create(array $data): int
    {
        $entry = Entry::create($data);
        return $entry->id;
    }

    /**
     *  Update an existing entry
     *
     *  @param $id
     *  @param array $data
     */
    public function update($id, array $data): void
    {
        $entry = Entry::findOrFail($id);
        $entry->update($data);
    }

    /**
     *  Delete an entry
     *
     *  @param $id
     *  @param array $data
     */
    public function delete($id): void
    {
        $entry = Entry::findOrFail($id);
        $entry->delete();
    }

    /**
     *  Copy an entry
     *
     *  @param $id
     *  @param array $data
     *  @return int
     */
    public function copy($id): int
    {
        $entry = Entry::findOrFail($id);
        $copy = $entry->replicate();
        $copy->name = $copy->name . ' - COPY';
        $copy->status = 'prohibited';
        $copy->save();
        return $copy->id;
    }

    /**
     *  Delete all entries
     */
    public function deleteAll(): void
    {
        Entry::query()->delete();
    }

    /**
     *  Index using eleasticsearch
     */
    public function index(): void
    {
        Entry::addAllToIndex();
    }

    /**
     *  Index using eleasticsearch
     */
    public function indexExists(): int
    {
        return Entry::indexExists();
    }

    /**
     *  search using eleasticsearch
     *
     *  @param string $query
     */
    public function search($query): object
    {
        $limit = 500;
        return Entry::searchByQuery(
            [
                'multi_match' => [
                    'query' => $query,
                    'fields' => [
                        'name',
                        'description',
                        'category',
                        'sub_category',
                        'functionality',
                        'service_levels',
                        'interfaces'
                    ],
                    'fuzziness' => 'auto',
                ]
            ],
            null,
            ['name', 'version', 'description', 'status'],
            $limit
        );
    }
}
