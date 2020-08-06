<?php

namespace App\Repositories\Eloquent;

use App\User;
use App\Entry;
use App\Repositories\Interfaces\EntryRepositoryInterface;
use App\Link;
use App\EntryTag;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use App\Events\ModelChanged;

use ElasticquentClientTrait;

class EntryRepository implements EntryRepositoryInterface
{
    /**
     *  Return a specific entry
     *  @param $id
     */
    public function get($id): ?object
    {
        $entry = Entry::find($id);
        if ($entry) {
            // audit the viewing of the entry
            $actor_id = auth()->user()->id;
            $actor = User::class;
            // need to serialise the model
            $before = Entry::removeHiddenAttributes($entry->getOriginal());
            $after = Entry::removeHiddenAttributes($entry->getAttributes());
            event(new ModelChanged(
                $actor_id,
                $actor,
                Entry::class,
                $before,
                $after,
                'viewed'
            ));
        }
        return $entry;
    }

    /**
     *
     */
    public function all(): object
    {
        return Entry::all();
    }

    /**
     *  Return entries filtered by the supplied criteria
     *  @param Array $criteria
     *  @return Collection
     */
    public function filter(array $criteria): object
    {
        $query = DB::table('entries');
        // search for an entry based on its status
        if (array_key_exists('status', $criteria)) {
            $query->where('status', $criteria['status']);
        }
        // search for an entry based on its category
        if (array_key_exists('category', $criteria)) {
            $query->where('category', $criteria['category']);
        }
        // search for an entry based on its sub-category
        if (array_key_exists('sub_category', $criteria)) {
            $query->where('sub_category', $criteria['sub_category']);
        }
        $page_size = $this->calculatePageSize($query->count());
        return $query->orderBy('name')->orderBy('version')->paginate($page_size);
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
        $dependencies = $entry->children;
        $tags = $entry->tags;
        $newEntry = DB::transaction(function () use ($entry, $dependencies, $tags) {
            // copy the entry
            $copy = $entry->replicate();
            $copy->name = $copy->name . ' - COPY';
            $copy->status = 'prohibited';
            $copy->save();
            $id = $copy->id;
            // copy the dependencies
            foreach ($dependencies as $dependency) {
                $link = new Link;
                $link->item1_id = $id;
                $link->item2_id = $dependency->item2_id;
                $link->save();
            }
            // copy the user defined tags
            foreach ($tags as $tag) {
                $entryTag = new EntryTag;
                $entryTag->entry_id = $id;
                $entryTag->tag_id = $tag->id;
                $entryTag->save();
            }
            return $copy;
        });
        return $newEntry->id;
    }

    /**
     *  Delete all entries
     */
    public function deleteAll(): void
    {
        Entry::query()->delete();
    }

    // ********** Elasticsearch functions **********

    /**
     *  Index all entries
     */
    public function index(): void
    {
        Entry::addAllToIndex();
    }

    /**
     *  Re-index all entries
     */
    public function reindex(): void
    {
        Entry::reindex();
    }

    /**
     *  Delete the index
     */
    public function deleteIndex()
    {
        Entry::deleteIndex();
    }

    /**
     *  Rebuild the index
     */
    public function rebuildIndex(): void
    {
        $this->deleteIndex();
        $this->index();
    }


    /**
     *  Check if an index exists
     */
    public function indexExists(): int
    {
        return Entry::indexExists();
    }


    /**
     *  simple search using eleasticsearch
     *
     *  @param string $query
     */
    public function search($query): object
    {
        return Entry::search($query);
    }

    /**
     *  search using eleasticsearch
     *
     *  @param string $query
     */
    public function multiMatchSearch($query): object
    {
        $limit = 500;
        return Entry::searchByQuery(
            [
                'multi_match' => [
                    'query' => $query,
                    'fields' => [
                        // 'name',
                        // 'version',
                        'name_version^3',
                        'description^2',
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

    /**
     *  wildcard search using eleasticsearch
     *
     *  @param string $query
     */
    public function complexSearch($query): object
    {
        $limit = 500;
        $model = new Entry();
        $params = $model->getBasicEsParams();
        $params['body'] = [
            'query' => [
                'simple_query_string' => [
                    'query' => $query,
                    'fields' => [
                        // 'name',
                        // 'version',
                        'name_version^3',
                        'description^2',
                        'category',
                        'sub_category',
                        'functionality',
                        'service_levels',
                        'interfaces'
                    ]
                ]
            ],
            'size' => $limit
        ];
        return $model->complexSearch($params);
    }
}
