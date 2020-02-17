<?php

namespace App\Http\Controllers\Catalogue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;

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
        $results = $this->entryRepository->search($request->phrase);
        Log::debug('Catalogue search returned ' . $results->count() . ' ' . Str::plural('result', $results->count()) . '.');
        $labels = $this->statusRepository->labels();
        $catalogue_size = count($this->entryRepository->all());
        $page_size = $this->entryRepository->calculatePageSize($results->count());
        $entries = $results->sortBy('name')->sortBy('version')->Paginate($page_size);
        $labels = $this->statusRepository->labels();
        return view('catalogue.links.results', compact('entry_id', 'entries', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // perform validation (should change to a form request)
        if (!$request->has('entry_id')) {
            abort(500);
        }
        // check that at least one of the checkboxes is selected
        $request->validate([
          'link' => 'required'
        ], [
          'link.required' => 'You must select at least one dependency.'
        ]);

        // store the links
        foreach ($request->link as $link) {
            Link::create(['item1_id' => $request->entry_id, 'item2_id' => $link, 'relationship' => 'composed_of']);
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
