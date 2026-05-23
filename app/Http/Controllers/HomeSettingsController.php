<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSetting;
use App\Support\MediaUpload;
use App\Support\PublicUploadedFile;
use Illuminate\Support\Facades\Schema;

class HomeSettingsController extends Controller
{

     public function index()
    {
        $settings = HomeSetting::forCurrentTenant();
        $faqs = ($settings && $settings->faqs !== null)
            ? $settings->faqs
            : config('tenant_hazel_home.faqs', []);

        return view('tenants.setting.home_page_settings', compact('settings', 'faqs'));
    }
   public function home_setting_store(Request $request)
{
    // 🔹 Validate inputs
    $request->validate([
        ...MediaUpload::imageFieldRules('banner_image'),
        ...MediaUpload::imageFieldRules('aboutus_image'),

        'benner_title' => 'nullable|string|max:255',
        'benner_description' => 'nullable|string|max:65000',
        'aboutus_title' => 'nullable|string|max:255',
        'aboutus_description' => 'nullable|string|max:65000',
        'card_one_title' => 'nullable|string|max:255',
        'card_one_description' => 'nullable|string|max:65000',
        'card_two_title' => 'nullable|string|max:255',
        'card_two_description' => 'nullable|string|max:65000',
        'card_three_title' => 'nullable|string|max:255',
        'card_three_description' => 'nullable|string|max:65000',
        'faq_question' => 'nullable|array',
        'faq_question.*' => 'nullable|string|max:500',
        'faq_answer' => 'nullable|array',
        'faq_answer.*' => 'nullable|string|max:5000',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:1000',
        'meta_keywords' => 'nullable|string|max:500',
    ]);

    // 🔹 Fetch or create settings for this tenant
    $settings = HomeSetting::forCurrentTenant();

    $settings->banner_image = PublicUploadedFile::resolve(
        $request,
        'banner_image',
        $settings->banner_image,
        'uploads/banners'
    );
    $settings->aboutus_image = PublicUploadedFile::resolve(
        $request,
        'aboutus_image',
        $settings->aboutus_image,
        'uploads/aboutus'
    );


 $settings->benner_title  = $request->benner_title;
    $settings->benner_description = $request->benner_description;
    $settings->aboutus_title = $request->aboutus_title;
    $settings->aboutus_description = $request->aboutus_description;
    $settings->card_one_title = $request->card_one_title;
    $settings->card_one_description = $request->card_one_description;
    $settings->card_two_title = $request->card_two_title;
    $settings->card_two_description = $request->card_two_description;
    $settings->card_three_title = $request->card_three_title;
    $settings->card_three_description = $request->card_three_description;
    $settings->faqs = $this->normalizeFaqs(
        $request->input('faq_question', []),
        $request->input('faq_answer', [])
    );
    if (Schema::hasColumn('home_settings', 'meta_title')) {
        $settings->meta_title = $request->meta_title;
        $settings->meta_description = $request->meta_description;
        $settings->meta_keywords = $request->meta_keywords;
    }
    $settings->save();

    return redirect()->back()->with('success', '✅ Home page settings updated successfully!');
}

    /** @return array<int, array{q: string, a: string}> */
    protected function normalizeFaqs(array $questions, array $answers): array
    {
        $faqs = [];
        $count = max(count($questions), count($answers));

        for ($i = 0; $i < $count; $i++) {
            $q = trim((string) ($questions[$i] ?? ''));
            $a = trim((string) ($answers[$i] ?? ''));
            if ($q !== '' && $a !== '') {
                $faqs[] = ['q' => $q, 'a' => $a];
            }
        }

        return $faqs;
    }

}
