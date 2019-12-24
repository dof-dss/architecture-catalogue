<?php

namespace App\Http\Controllers\Catalogue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

// models
use App\Entry;


class EntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // replace this with an API call
        $entries = Entry::Paginate(15);

        return view('catalogue.index', compact('entries'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('catalogue.create');
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
          'href' => 'url|nullable',
          'description' => 'required',
          'category' => 'required',
          'sub_category' => 'required'
        ], [
          'name.required' => 'The name of the component is required.',
          'href.url' => 'The associated URL is invalid.'
        ]);

        // store the entry
        $entry = new Entry;
        $entry->name = $request->name;
        $entry->description = $request->description;
        $entry->href = $request->href;
        $entry->category = $request->category;
        $entry->sub_category = $request->sub_category;
        $entry->save();

        // now redirect back to the index page
        return redirect('/entries');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        return view('catalogue.edit', compact('entry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $entry = Entry::findOrFail($id);

      // perform validation (should change to a form request)
      $request->validate([
        'name' => 'required',
        'href' => 'url|nullable',
        'description' => 'required',
        'category' => 'required|',
        'sub_category' => 'required'
      ], [
        'name.required' => 'The name of the component is required.',
        'href.url' => 'The associated URL is invalid.'
      ]);

      // update the entry
      $entry->name = $request->name;
      $entry->description = $request->description;
      $entry->href = $request->href;
      $entry->category = $request->category;
      $entry->sub_category = $request->sub_category;
      $entry->save();

      // now redirect back to the index page
      return redirect('/entries');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
     * Delete the entire catalogue
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadCatalogue()
    {
        return view('helpers.upload');
    }

    /**
     * Delete the entire catalogue
     *
     * @return \Illuminate\Http\Response
     */
    public function importCatalogue(Request $request)
    {
        // validation - check for file, type and size

        $request->file_upload_1->store('uploads');

        // load the file into memory
        $json = json_decode(Storage::disk('local')->get('uploads/catalogue.json'));

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
}
