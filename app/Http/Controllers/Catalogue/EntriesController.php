<?php

namespace App\Http\Controllers\Catalogue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

// specific exception handler
use App\Exceptions\AuditException;

use Illuminate\Support\Str;
use Carbon\Carbon;

// form requests
use App\Http\Requests\StoreEntry;

// repositories
use App\Repositories\Interfaces\EntryRepositoryInterface as EntryRepository;
use App\Repositories\Interfaces\StatusRepositoryInterface as StatusRepository;
use App\Repositories\Interfaces\CategoriesRepositoryInterface as CategoriesRepository;

class EntriesController extends Controller
{
    protected $entryRepository;
    protected $statusRepository;
    protected $categoriesRepository;

    public function __construct(
        EntryRepository $entryRepository,
        StatusRepository $statusRepository,
        CategoriesRepository $categoriesRepository
    ) {
        $this->entryRepository = $entryRepository;
        $this->statusRepository = $statusRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $catalogue_size = count($this->entryRepository->all());
        if ($request->is('api/*')) {
            return $this->entryRepository->all();
        } else {
            // build up the filter criteria
            $criteria = [];
            // search for an entry based on its status
            if ($request->has('status')) {
                $status = $request->status;
                if ($status != "") {
                    $criteria['status'] = $status;
                }
            }
            // search for an entry based on its category / sub-category
            $category_subcategory = null;
            if ($request->has('category_subcategory')) {
                $category_subcategory = $request->category_subcategory;
                if ($category_subcategory != "") {
                    // need to split category_subcategory into its component parts which are separated by a '-'
                    $parts = explode("-", $category_subcategory);
                    // validate the two parts against the acceptable values
                    $criteria['category'] = $parts[0];
                    $criteria['sub_category'] = $parts[1];
                }
            }
            $entries = $this->entryRepository->filter($criteria);
            $statuses = $this->statusRepository->all();
            $labels = $this->statusRepository->labels();
            $categories = $this->categoriesRepository->all();
            $status = $criteria['status'] ?? null;
            $sub_category = $criteria['sub_category'] ?? null;
            return view(
                'catalogue.index',
                compact('entries', 'statuses', 'labels', 'catalogue_size', 'status', 'categories', 'sub_category')
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = $this->statusRepository->all();
        $categories = $this->categoriesRepository->all();
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

        $entry = [];
        $entry['name'] = $request->name;
        $entry['version'] = $request->version;
        $entry['description'] = $request->description;
        $entry['href'] = $request->href;
        $entry['category'] = $parts[0];
        $entry['sub_category'] = $parts[1];
        $entry['status'] = $request->status;
        $entry['functionality'] = $request->functionality;
        $entry['service_levels'] = $request->service_levels;
        $entry['interfaces'] = $request->interfaces;

        // create may partially fail due to external service calls
        try {
            $id = $this->entryRepository->create($entry);
        } catch (AuditException $ex) {
            $ex->report(get_class($this) . ":" . __FUNCTION__);
            return back()->withErrors('There was an error auditing your last action. Please contact support.');
        }

        // now view the newly created entry
        return redirect('/entries/' . $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entry = $this->entryRepository->get($id);
        $labels = $this->statusRepository->labels();
        return view('catalogue.view', compact('entry', 'labels'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entry = $this->entryRepository->get($id);
        $statuses = $this->statusRepository->all();
        $categories = $this->categoriesRepository->all();
        return view('catalogue.edit', compact('entry', 'statuses', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEntry $request, $id)
    {
        // need to split category_subcategory into its component parts which are separated by a '-'
        $parts = explode("-", $request->category_subcategory);
        // validate the two parts against the acceptable values

        // update the entry
        $entry['name'] = $request->name;
        $entry['version'] = $request->version;
        $entry['description'] = $request->description;
        $entry['href'] = $request->href;
        $entry['category'] = $parts[0];
        $entry['sub_category'] = $parts[1];
        $entry['status'] = $request->status;
        $entry['functionality'] = $request->functionality;
        $entry['service_levels'] = $request->service_levels;
        $entry['interfaces'] = $request->interfaces;

        // update may partially fail due to external service calls
        try {
            $this->entryRepository->update($id, $entry);
        } catch (AuditException $ex) {
            $ex->report(get_class($this) . ":" . __FUNCTION__);
            return back()->withErrors('There was an error auditing your last action. Please contact support.');
        }

        // now view the updated entry
        return redirect('/entries/' . $id);
    }

    /**
    * Confirm the deletion of the catalogue entry.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function delete($id)
    {
        $entry = $this->entryRepository->get($id);
        return view('catalogue.delete', compact('entry'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // delete may partially fail due to external service calls
        try {
            $this->entryRepository->delete($id);
        } catch (AuditException $ex) {
            $ex->report(get_class($this) . ":" . __FUNCTION__);
            return redirect('/entries')->withErrors('There was an error auditing your last action. Please contact support.');
        }

        return redirect('/entries');
    }

    /**
     * Copy a catalogue entry
     *
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */
    public function copy($id)
    {
        // exceptions have not been handled
        $newId = $this->entryRepository->copy($id);
        return redirect('/entries/' . $newId);
    }

    /**
     * Delete the entire catalogue
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteCatalogue()
    {
        $this->entryRepository->deleteAll();
        return redirect('/entries');
    }

    /**
     * Index the entire catalogue using elasticsearch
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCatalogue()
    {
        $this->entryRepository->index();
        return redirect()->back()->with('status', 'successful');
    }

    /**
     * Display the search page
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $statuses = $this->statusRepository->all();
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
        if (!$this->entryRepository->indexExists()) {
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
        $results = $this->entryRepository->search($request->phrase);
        Log::debug('Catalogue search returned ' . $results->count() . ' ' . Str::plural('result', $results->count()) . '.');
        $labels = $this->statusRepository->labels();
        $catalogue_size = count($this->entryRepository->all());
        $page_size = $this->entryRepository->calculatePageSize($results->count());
        $entries = $results->sortBy('name')->sortBy('version')->Paginate($page_size);
        return view('catalogue.results', compact('entries', 'labels', 'catalogue_size'));
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
            $entry = [];
            $entry['name'] = $json_entry->name;
            $entry['description'] = $json_entry->description;
            $entry['href'] = isset($json_entry->href) ? $json_entry->href : null;
            $entry['category'] = $json_entry->category;
            $entry['sub_category'] = $json_entry->sub_category;
            $this->entryRepository->create($entry);
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
        $data = json_encode(array('entries' => $this->entryRepository->all()));
        $fileName = 'downloads/catalogue_' . time() . '.json';
        Storage::put($fileName, $data);
        return Storage::download($fileName, 'catalogue_' . time() . '.json');
    }
}
