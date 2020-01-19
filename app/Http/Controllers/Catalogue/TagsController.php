<?php

namespace App\Http\Controllers\Catalogue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

// models
use App\Tag;
use App\EntryTag;
use App\Entry;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Entry $entry)
    {
        $tags = Tag::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);
        return view('catalogue.tags.index', compact('entry', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check we have an entry id
        if (!$request->has('entry_id')) {
            abort(500);
        }

        // check we have a valid tag and that it is not already linked
        $request->validate([
            'tag_id' => [
                'required',
                'integer',
                Rule::exists('tags', 'id'),
                Rule::unique('entry_tag')->where(function ($query) use ($request) {
                            return $query->where('entry_id', $request->entry_id);
                })
            ]
        ], [
          'tag_id.required' => 'You must select at least one tag.',
          'tag_id.unique' => 'You have already used this tag.'
        ]);

        // store the relationship between the entry and the tag
        EntryTag::create(['entry_id' => $request->entry_id, 'tag_id' => $request->tag_id]);

        // now redirect back to the list of tags
        return redirect('/entries/' . $request->entry_id . '/tags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry, Tag $tag)
    {
        $entry_tag = EntryTag::where('entry_id', $entry->id)->where('tag_id', $tag->id)->firstOrFail();
        $entry_tag->delete();
        return redirect('/entries/' . $entry->id . '/tags');
    }

    /**
     * Create a new tag and and associate with an entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createAndStore(Request $request)
    {
        // check we have an entry id
        if (!$request->has('entry_id')) {
            abort(500);
        }

        // check we have a valid tag and that it does not already exist
        $request->validate([
          'new_tag' => [
              'required',
              'string',
              'min:3',
               Rule::unique('tags', 'name')
            ]
        ], [
          'new_tag.required' => 'You must provide a tag name.',
          'new_tag.size' => 'You must enter at least 3 characters.',
          'new_tag.unique' => 'This tag has already been created.'
        ]);

        DB::transaction(function () use ($request) {
            // create the tag
            $tag = Tag::create(['name' => $request->new_tag]);
            // link to the entry
            EntryTag::create(['entry_id' => $request->entry_id, 'tag_id' => $tag->id]);
        });


        // now redirect back to the list of tags
        return redirect('/entries/' . $request->entry_id . '/tags');
    }
}
