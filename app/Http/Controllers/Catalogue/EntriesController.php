<?php

namespace App\Http\Controllers\Catalogue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;

use Carbon\Carbon;

// models
use App\Entry;

// form requests
use App\Http\Requests\StoreEntry;

class EntriesController extends Controller
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

    protected $categories = array(
        'Business Applications' => array(
            'Information Consumer Applications',
            'Brokering Applications',
            'Information Provider Applications',
            'Shared Services Applications'
        ),
        'Infrastructure Applications' => array(
            'Productivity',
            'Development Tools',
            'Libraries',
            'Management Utilities',
            'Storage Management Utilities'
        ),
        'Application Platform' => array(
            'Software Engineering Services',
            'Operating System Services',
            'Security Services',
            'Human Interaction Services',
            'Data Interchange Services',
            'Data Management Services',
            'Network Services'
        ),
        'Technology Platforms' => array(
            'Hosting Services',
            'Infrastructure as a Service',
            'Platform as a Service',
            'Software as a Service'
        ),
        'Physical Infrastructure' => array(
            'Data Centres',
            'Data Networks',
            'End User Devices',
            'Server Devices'
        ),
        'Other' => array(
            'Not categorised'
        )
    );

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
            $status = null;
            $entry = (new Entry)->newQuery();
            // search for an entry based on its status
            if ($request->has('status')) {
                $status = $request->input('status');
                if ($request->input('status') != "") {
                    $entry->where('status', $request->input('status'));
                }
            }
            // search for an entry based on its category / sub-category
            $category_subcategory = null;
            $category = null;
            $sub_category = null;
            if ($request->has('category_subcategory')) {
                $category_subcategory = $request->input('category_subcategory');
                if ($category_subcategory != "") {
                    // need to split category_subcategory into its component parts which are separated by a '-'
                    $parts = explode("-", $category_subcategory);
                    // validate the two parts against the acceptable values
                    $category = $parts[0];
                    $sub_category = $parts[1];
                    $entry->where('category', $category);
                    $entry->where('sub_category', $sub_category);
                }
            }
            $page_size = $this->calculatePageSize($entry->count());
            $entries = $entry->orderBy('name')->Paginate($page_size);
            $statuses = $this->statuses;
            $labels = $this->labels;
            $categories = $this->categories;
            return view('catalogue.index', compact('entries', 'statuses', 'labels', 'catalogue_size', 'status', 'categories', 'sub_category'));
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
        $categories = $this->categories;
        return view('catalogue.create', compact('statuses', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEntry $request)
    {
        // need to split category_subcategory into its component parts which are separated by a '-'
        $parts = explode("-", $request->category_subcategory);
        // validate the two parts against the acceptable values

        $entry = new Entry;
        $entry->name = $request->name;
        $entry->version = $request->version;
        $entry->description = $request->description;
        $entry->href = $request->href;
        $entry->category = $parts[0];
        $entry->sub_category = $parts[1];
        $entry->status = $request->status;
        $entry->functionality = $request->functionality;
        $entry->service_levels = $request->service_levels;
        $entry->interfaces = $request->interfaces;
        $entry->save();

        // now redirect back to the index page
        return redirect('/entries/' . $entry->id);
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
        $categories = $this->categories;
        return view('catalogue.edit', compact('entry', 'statuses', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEntry $request, Entry $entry)
    {
        // need to split category_subcategory into its component parts which are separated by a '-'
        $parts = explode("-", $request->category_subcategory);
        // validate the two parts against the acceptable values

        // update the entry
        $entry->name = $request->name;
        $entry->version = $request->version;
        $entry->description = $request->description;
        $entry->href = $request->href;
        $entry->category = $parts[0];
        $entry->sub_category = $parts[1];
        $entry->status = $request->status;
        $entry->functionality = $request->functionality;
        $entry->service_levels = $request->service_levels;
        $entry->interfaces = $request->interfaces;
        $entry->save();

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
     * Index the entire catalogue using elasticsearch
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCatalogue()
    {
        Entry::addAllToIndex();
        return redirect()->back()->with('status', 'successful');
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
        // check that an index exists
        if (!Entry::indexExists()) {
            abort(500);
            // could fall back to a SQL search?
        }

        // validation
        $request->validate([
          'phrase' => 'required|min:3'
        ], [
          'phrase.required' => 'Enter a word or phrase',
          'phrase.min' => 'Enter at least 3 characters'
        ]);
        // elastic search
        $results = Entry::searchByQuery(
            [
                'multi_match' => [
                    'query' => $request->phrase,
                    'fields' => [
                        'name',
                        'description',
                        'category',
                        'sub_category',
                        'functionality',
                        'service_levels',
                        'interfaces'
                    ],
                    'fuzziness' => 'auto'
                ]
            ],
            null,
            ['name', 'version', 'description', 'status']
        );
        Log::debug('Catalogue search returned ' . $results->count() . ' ' . Str::plural('result', $results->count()) . '.');
        $labels = $this->labels;
        $catalogue_size = Entry::count();
        $page_size = $this->calculatePageSize($results->count());
        $entries = $results->sortBy('name')->Paginate($page_size);
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
        $copy->name = $copy->name . ' - COPY';
        $copy->status = 'prohibited';
        $copy->save();
        return redirect('/entries/' . $copy->id);
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
