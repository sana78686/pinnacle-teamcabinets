<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DoorColors;
use App\Models\HomeSetting;
use App\Models\SiteSetting;

use App\Models\Page;
use Illuminate\Http\Request;

class TenantPageController extends Controller
{
    public function index()
    {
        $pages = Page::with('parent')->orderBy('order_no')->paginate(10);
        return view('frontend.index', compact('pages'));
    }

    public function create()
    {
        $parents = Page::whereNull('parent_id')->pluck('title','id');
        return view('frontend.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages,slug',
        ]);

        Page::create($request->all());
        return redirect()->route('pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        $parents = Page::whereNull('parent_id')->where('id','!=',$page->id)->pluck('title','id');
        return view('frontend.edit', compact('page','parents'));
    }

    public function show($slug = null)
    {

         if (is_null($slug)) {
            $pages = Page::with('parent')->orderBy('order_no')->paginate(10);
            $settings = SiteSetting::first();
            $doorstyles= DoorColors::all();
            $homesettings = HomeSetting::first();

                    // dd($doorstyles->all());
$bennersection = $homesettings &&
                  $homesettings->banner_image &&
                  $homesettings->benner_title &&
                  $homesettings->benner_description
                  ? $homesettings
                  : null;

$aboutussection = $homesettings &&
                   $homesettings->aboutus_image &&
                   $homesettings->aboutus_title &&
                   $homesettings->aboutus_description
                   ? $homesettings
                  : null;

$cardsection = $homesettings &&
               $homesettings->card_one_title &&
               $homesettings->card_one_description &&
               $homesettings->card_two_title &&
               $homesettings->card_two_description &&
               $homesettings->card_three_title &&
               $homesettings->card_three_description
               ? $homesettings
                  : null;
$settingsCompleted = $settings && $settings->phone && $settings->email;
            return view('frontend.superusers.home', compact('pages','settings' ,'settingsCompleted','doorstyles','bennersection','aboutussection','cardsection','homesettings'));
        }

        // If slug is provided, show the CMS page
        $page = Page::with('parent')->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

                    $pages = Page::with('parent')->orderBy('order_no')->paginate(10);
                    $doorstyles= DoorColors::first();
                    $settings = SiteSetting::first();
                    // dd($doorstyles->all());
  $settingsCompleted = $settings && $settings->logo && $settings->phone && $settings->email && $settings->address ;
        return view('frontend.superusers.page', compact('pages','page','settings','settingsCompleted','doorstyles'));
    }


    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages,slug,'.$page->id,
        ]);

        $page->update($request->all());
        return redirect()->route('pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Page deleted.');
    }
}
