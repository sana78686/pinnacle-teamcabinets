<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSetting;

class HomeSettingsController extends Controller
{

     public function index()
    {
        $settings = HomeSetting::first();
        $faqs = ($settings && $settings->faqs !== null)
            ? $settings->faqs
            : config('tenant_hazel_home.faqs', []);

        return view('tenants.setting.home_page_settings', compact('settings', 'faqs'));
    }
   public function home_setting_store(Request $request)
{
    // 🔹 Validate inputs
    $request->validate([
        'banner_image' => 'nullable|image|max:2048',
        'aboutus_image' => 'nullable|image|max:2048',

        'benner_title' => 'nullable|string|max:255',
        'benner_description' => 'nullable|string|max:500',
        'aboutus_title' => 'nullable|string|max:255',
        'aboutus_description' => 'nullable|string|max:500',
        'card_one_title' => 'nullable|string|max:255',
        'card_one_description' => 'nullable|string|max:500',
        'card_two_title' => 'nullable|string|max:255',
        'card_two_description' => 'nullable|string|max:500',
        'card_three_title' => 'nullable|string|max:255',
        'card_three_description' => 'nullable|string|max:500',
        'faq_question' => 'nullable|array',
        'faq_question.*' => 'nullable|string|max:500',
        'faq_answer' => 'nullable|array',
        'faq_answer.*' => 'nullable|string|max:5000',
    ]);

    // 🔹 Fetch or create settings
    $settings = HomeSetting::first() ?? new HomeSetting();

    // 🔹 Helper for file upload
    $uploadFile = function ($fileInput, $path, $oldFile = null) use ($request) {
        if ($request->hasFile($fileInput)) {
            // Delete old file if exists
            if ($oldFile && file_exists(public_path($oldFile))) {
                @unlink(public_path($oldFile));
            }

            $file = $request->file($fileInput);
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($path), $filename);
            return "$path/$filename";
        }
        return $oldFile;
    };

    // 🔹 Upload files

    $settings->banner_image = $uploadFile('banner_image', 'uploads/banners', $settings->banner_image);
    $settings->aboutus_image = $uploadFile('aboutus_image', 'uploads/aboutus', $settings->aboutus_image);


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
    // 🔹 Save all
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
