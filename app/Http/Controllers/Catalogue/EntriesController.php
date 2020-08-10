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

// needed for Swagger definition
use App\Entry;

// form requests
use App\Http\Requests\StoreEntry;

// repositories
use App\Repositories\Interfaces\EntryRepositoryInterface as EntryRepository;
use App\Repositories\Interfaces\StatusRepositoryInterface as StatusRepository;
use App\Repositories\Interfaces\CategoriesRepositoryInterface as CategoriesRepository;

/**
 * @OA\Info(
 *      version="1.0.11",
 *      title="Architecture Catalogue API Documentation",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="ea-team@ea.finance-ni.gov.uk"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
 *
 * @OA\Tag(
 *     name="Architecture Catalogue",
 *     description="API Endpoints of Architecture Catalogue"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="apiToken",
 *      scheme="bearer",
 *      type="http"
 * )
 */

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
     * @OA\Get(
     *      path="/entries",
     *      operationId="getEntriesList",
     *      tags={"Entries"},
     *      summary="Returns a list of catalogue entries",
     *      description="Returns a list of catalogue entries",
     *      security={{"apiToken" : {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/EntryResource")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->is('api/*')) {
            if ($request->user()->tokenCan('entry:index')) {
                return array(
                    'href' => url()->current(),
                    'timestamp' => Carbon::now(),
                    'entry_count' => $this->entryRepository->all()->count(),
                    'entries' => $this->entryRepository->all()
                );
            } else {
                return response()->json(['error' => 'You are not authorised to access this API'], 403);
            }
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
            $catalogue_size = count($this->entryRepository->all());
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

     /**
      * @OA\Get(
      *      path="/entries/{id}",
      *      operationId="getEntryById",
      *      tags={"Entries"},
      *      summary="Returns a catalogue entry",
      *      description="Returns catalogue entry data",
      *      security={{"apiToken" : {}}},
      *      @OA\Parameter(
      *          name="id",
      *          description="Entry id",
      *          required=true,
      *          in="path",
      *          @OA\Schema(
      *              type="integer"
      *          )
      *      ),
      *      @OA\Response(
      *          response=200,
      *          description="Successful operation",
      *          @OA\JsonContent(ref="#/components/schemas/EntriesResource")
      *       ),
      *      @OA\Response(
      *          response=400,
      *          description="Bad Request"
      *      ),
      *      @OA\Response(
      *          response=401,
      *          description="Unauthenticated",
      *      ),
      *      @OA\Response(
      *          response=403,
      *          description="Forbidden"
      *      ),
      *      @OA\Response(
      *          response=404,
      *          description="Entry does not exist"
      *      )
      * )
      */

    public function show(Request $request, $id)
    {
        if ($request->is('api/*')) {
            if ($request->user()->tokenCan('entry:view')) {
                if ($entry = $this->entryRepository->get($id)) {
                    return array(
                        'href' => url()->current(),
                        'timestamp' => Carbon::now(),
                        'entry' => $entry
                    );
                } else {
                    return response()->json(['error' => 'Entry does not exist'], 404);
                }
            } else {
                return response()->json(['error' => 'You are not authorised to access this API'], 403);
            }
        } else {
            if ($entry = $this->entryRepository->get($id)) {
                $labels = $this->statusRepository->labels();
                return view('catalogue.view', compact('entry', 'labels'));
            } else {
                abort(404);
            }
        }
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
        return redirect('/entries/' . $id . '?path=' . urlencode(request()->query('path')));
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

        // validation - prevent deletion of an entry that is a dependency of another
        if ($entry->parents->count() > 0) {
            return view('catalogue.delete', compact('entry'))
                ->withErrors('This entry cannot be deleted. Other entries are dependent upon it.');
        }
        // confirm delete
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
     * Reindex the entire catalogue using elasticsearch
     *
     * @return \Illuminate\Http\Response
     */
    public function reindexCatalogue()
    {
        $this->entryRepository->reindex();
        return redirect()->back()->with('status', 'successful');
    }

    /**
     * Rebuild the catalogue index using elasticsearch
     *
     * @return \Illuminate\Http\Response
     */
    public function rebuildIndex()
    {
        $this->entryRepository->rebuildIndex();
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

        $phrase = $request->phrase;
        // pick up the sort parameters (should validate these at some point)
        $last_sort = $request->has('last_sort') ? $request->last_sort : 'none';
        $sort = $request->has('sort') ? $request->sort : 'name_version';
        if ($sort == $last_sort) { // toggle the sort order
            $order = $request->order == 'asc' ? 'desc' : 'asc';
        } else {
            $order = $request->has('order') ? $request->order : 'asc';
        }
        // search using Elasticsearch
        $results = $this->entryRepository->complexSearch($phrase);
        $labels = $this->statusRepository->labels();
        $catalogue_size = count($this->entryRepository->all());
        $page_size = $this->entryRepository->calculatePageSize($results->count());
        if ($order == 'desc') {
            $entries = $results->sortByDesc($sort, SORT_NATURAL|SORT_FLAG_CASE)->Paginate($page_size);
        } else {
            $entries = $results->sortBy($sort, SORT_NATURAL|SORT_FLAG_CASE)->Paginate($page_size);
        }
        return view('catalogue.results', compact('entries', 'labels', 'catalogue_size', 'phrase', 'sort', 'order'));
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
        foreach ($json->entries as $json_entry) {
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
        $data = json_encode(
            array(
              'href' => url()->current(),
              'timestamp' => Carbon::now(),
              'entry_count' => $this->entryRepository->all()->count(),
              'entries' => $this->entryRepository->all()
            )
        );
        $fileName = 'downloads/catalogue_' . time() . '.json';
        Storage::put($fileName, $data);
        return Storage::download($fileName, 'catalogue_' . time() . '.json');
    }
}
