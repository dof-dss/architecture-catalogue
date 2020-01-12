<?php

namespace App\Http\Controllers\Catalogue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;

// models
use App\Link;
use App\Entry;

class LinksController extends Controller
{
    // this should be an include file

    protected $statuses = [
      'approved',
      'unapproved',
      'prohibited',
      'retiring',
      'evaluating'
    ];

    protected $labels = [
      'approved' => 'label--green',
      'unapproved' => 'label--black',
      'prohibited'=> 'label--red',
      'retiring' => 'label--orange',
      'evaluating' => 'label--blue'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Entry $entry)
    {
        $labels = $this->labels;
        return view('catalogue.links.index', compact('entry', 'labels'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Entry $entry)
    {
        $statuses = $this->statuses;
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
        //  validation ?

        if (!$request->has('entry_id')) {
            abort(404);
        }
        $entry = (new Entry)->newQuery();
        // search for an entry based on its name
        if ($request->has('name')) {
            if ($request->input('name') != "") {
                $entry->where('name', 'like', '%'. $request->input('name') . '%');
            }
        }
        // search for an entry based on its description
        if ($request->has('description')) {
            if ($request->input('description') != "") {
                $entry->where('description', 'like', '%'. $request->input('description') . '%');
            }
        }
        // search for an entry based on its status
        if ($request->has('status')) {
            if ($request->input('status') != "") {
                $entry->where('status', $request->input('status'));
            }
        }
        $entry_id = $request->entry_id;

        $page_size = $this->calculatePageSize($entry->count());
        $entries = $entry->orderBy('name')->get();
        Log::debug('Catalogue search returned ' . $entries->count() . ' ' . Str::plural('result', $entries->count()) . '.');
        $labels = $this->labels;
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
    public function destroy(Entry $entry, Link $link)
    {
        $link->delete();
        return redirect('/entries/' . $entry->id);
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
