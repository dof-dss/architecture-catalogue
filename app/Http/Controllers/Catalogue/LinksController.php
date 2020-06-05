<?php

namespace App\Http\Controllers\Catalogue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;

use App\Http\Requests\StoreLinks;
use App\Entry;

// models
use App\Link;

// repositories
use App\Repositories\Interfaces\EntryRepositoryInterface as EntryRepository;
use App\Repositories\Interfaces\StatusRepositoryInterface as StatusRepository;

class LinksController extends Controller
{
    protected $entryRepository;
    protected $statusRepository;

    public function __construct(
        EntryRepository $entryRepository,
        StatusRepository $statusRepository
    ) {
        $this->entryRepository = $entryRepository;
        $this->statusRepository = $statusRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $entry = $this->entryRepository->get($id);
        $labels = $this->statusRepository->labels();
        return view('catalogue.links.index', compact('entry', 'labels'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $entry = $this->entryRepository->get($id);
        $statuses = $this->statusRepository->all();
        return view('catalogue.links.search', compact('entry', 'statuses'));
    }

    /**
     * Search the catalogue and return the results
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function searchCatalogue(Request $request)
    {
        // check that an index exists
        if (!$this->entryRepository->indexExists()) {
            abort(500);
            // could fall back to a SQL search?
        }
        // validation
        if (!$request->has('entry_id')) {
            abort(404);
        }
        $request->validate([
          'phrase' => 'required|min:3'
        ], [
          'phrase.required' => 'Enter a word or phrase',
          'phrase.min' => 'Enter at least 3 characters'
        ]);
        $entry_id = $request->entry_id;
        $entry = Entry::findOrFail($entry_id);
        $entry_description = $entry->name . ($entry->version ? '(' . $entry->version . ')' : '');
        $hits = $this->entryRepository->complexSearch($request->phrase);
        // remove the current entry if it is present in the search results
        $results = $hits->filter(function ($value, $key) use ($entry) {
            return $value->name_version != $entry->name_version;
        });
        $labels = $this->statusRepository->labels();
        $catalogue_size = count($this->entryRepository->all());
        $page_size = $this->entryRepository->calculatePageSize($results->count());
        $entries = $results->sortBy('_score')->Paginate($page_size);
        $labels = $this->statusRepository->labels();
        return view('catalogue.links.results', compact('entry_id', 'entry_description', 'entries', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLinks $request)
    {
        if (!$request->has('entry_id')) {
            abort(500);
        }

        // we need to return an error if nothing was selected
        $links = [];
        foreach ($request->all() as $key => $value) {
            if (Str::startsWith($key, 'link-')) {
                $links[$key] = $value;
            }
        }
        if (empty($links)) {
            return redirect()->back()->withErrors(['You must select at least one entry as a dependency']);
        }

        // we need to return an error if we try to link the entry to itself
        foreach ($request->all() as $key => $value) {
            if (Str::startsWith($key, 'link-')) {
                if ($value == $request->entry_id) {
                    return redirect()->back()->withErrors([
                        $key => 'You cannot make an entry dependent upon itself.'
                    ]);
                }
            }
        }

        // store the links
        foreach ($links as $key => $value) {
            Link::create(['item1_id' => $request->entry_id, 'item2_id' => $value, 'relationship' => 'composed_of']);
        }

        // now redirect back to the index page
        return redirect('/entries/' . $request->entry_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Link $link)
    {
        $link->delete();
        return redirect('/entries/' . $id);
    }

    /**
     *  Calculate page size to ensure there is a maximum of 5 pages
     *
     * @param Integer $num_rows
     * @return Integer
     */
    private function calculatePageSize($num_rows)
    {
        $page_size = config('app.page_size');
        $num_pages = ceil($num_rows / $page_size);
        if ($num_pages > config('app.max_pages')) {
            $page_size = ceil($num_rows / $num_pages);
        }
        return $page_size;
    }
}
