<?php

namespace App\Http\Controllers\Catalogue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

// models
use App\Entry;

class EntriesController extends Controller
{

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
    public function index(Request $request)
    {
        $catalogue_size = Entry::count();
        if ($request->is('api/*')) {
            return array(
              'href' => url()->current(),
              'timestamp' => Carbon::now(),
              'entries' => Entry::all());
        } else {
            $page_size = $this->calculatePageSize(Entry::count());
            $entries = Entry::orderBy('name')->Paginate($page_size);
            $statuses = $this->statuses;
            $labels = $this->labels;
            return view('catalogue.index', compact('entries', 'statuses', 'labels', 'catalogue_size'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = $this->statuses;
        return view('catalogue.create', compact('statuses'));
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
        $request->validate([
          'name' => 'required',
          'version' => 'required',
          'href' => 'url|nullable',
          'description' => 'required',
          'category' => 'required',
          'sub_category' => 'required',
          'status' => 'required',
          'functionality' => 'nullable',
          'service_levels' => 'nullable',
          'interfaces' => 'nullable',
          'related_sbbs' => 'nullable'
        ], [
          'name.required' => 'The name of the component is required.',
          'href.url' => 'The associated URL is invalid.'
        ]);

        // store the entry
        Entry::create(request([
          'name', 'version', 'description', 'href', 'category', 'sub_category', 'status', 'functionality', 'service_levels', 'interfaces', 'related_sbbs'
        ]));

        // now redirect back to the index page
        return redirect('/entries');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        $labels = $this->labels;
        return view('catalogue.view', compact('entry', 'labels'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        $statuses = $this->statuses;
        return view('catalogue.edit', compact('entry', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
        // perform validation (should change to a form request)
        $request->validate([
          'name' => 'required',
          'version' => 'required',
          'href' => 'url|nullable',
          'description' => 'required',
          'category' => 'required|',
          'sub_category' => 'required',
          'status' => 'required',
          'functionality' => 'nullable',
          'service_levels' => 'nullable',
          'interfaces' => 'nullable',
          'related_sbbs' => 'nullable'
        ], [
          'name.required' => 'The name of the component is required.',
          'href.url' => 'The associated URL is invalid.'
        ]);

        // update the entry
        $entry->update(request([
          'name', 'version', 'description', 'href', 'category', 'sub_category', 'status', 'functionality','service_levels', 'interfaces', 'related_sbbs'
        ]));

        // now redirect back to the index page
        return redirect('/entries/' . $entry->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        $entry->delete();
        return redirect('/entries');
    }

    /**
     * Delete the entire catalogue
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteCatalogue()
    {
        Entry::query()->delete();
        return redirect('/entries');
    }

    /**
     * Choose a file to upload and import into the catalogue
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadCatalogue()
    {
        return view('helpers.upload');
    }

    /**
     * Import the catalogue from a JSON file
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function importCatalogue(Request $request)
    {
        // validation - check for file, type and size
        $request->validate([
          'file_upload_1' => 'required|file'
        ], [
          'file_upload_1.required' => "Please select a JSON file to import"
        ]);

        $path = $request->file_upload_1->store('uploads');

        // load the file into memory
        $json = json_decode(Storage::disk('local')->get($path));

        // loop through all the entries and store in the database
        foreach ($json->technology_applications_catalogue->entries as $json_entry) {
            // store the entry
            $entry = new Entry;
            $entry->name = $json_entry->name;
            $entry->description = $json_entry->description;
            $entry->href = isset($json_entry->href) ? $json_entry->href : null;
            $entry->category = $json_entry->category;
            $entry->sub_category = $json_entry->sub_category;
            $entry->save();
        }

        return redirect('/entries');
    }

    /**
     * Export the catalogue to a JSON file
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportCatalogue(Request $request)
    {
        // need to name the array 'entries' to work with the architecture portal
        $data = json_encode(array('entries' => Entry::all()));
        $fileName = 'downloads/catalogue_' . time() . '.json';
        Storage::put($fileName, $data);
        return Storage::download($fileName, 'catalogue_' . time() . '.json');
    }


    /**
     * Display the search page
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $statuses = $this->statuses;
        return view('catalogue.search', compact('statuses'));
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

        $entry = (new Entry)->newQuery();

        // search for an entry based on its name
        if ($request->has('name')) {
            $entry->where('name', 'like', '%'. $request->input('name') . '%');
        }

        // search for an entry based on its description
        if ($request->has('description')) {
            $entry->where('description', 'like', '%'. $request->input('description') . '%');
        }

        // search for an entry based on its status
        if ($request->has('status')) {
            if ($request->input('status') != "") {
                $entry->where('status', $request->input('status'));
            }
        }

        $page_size = $this->calculatePageSize($entry->count());
        $entries = $entry->orderBy('name')->Paginate($page_size);
        $labels = $this->labels;
        $catalogue_size = Entry::count();
        return view('catalogue.results', compact('entries', 'labels', 'catalogue_size'));
    }

    /**
     * Copy a catalogue entry
     *
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */
    public function copy(Entry $entry)
    {
        $copy = $entry->replicate();
        $copy->name = $copy->name . ' [COPY]';
        $copy->status = 'prohibited';
        $copy->save();
        return redirect('/entries');
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
