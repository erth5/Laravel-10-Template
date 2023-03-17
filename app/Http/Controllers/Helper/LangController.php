<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use LaravelLang\Publisher\Constants\Locales as LocaleCode;

class LangController extends Controller
{
    /**
     * Display a view to change language
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('debug.lang');
    }

    /**
     * Change the language
     *
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);
        return back();
    }

    /** Proof current lang status
     * @return langStatus
     */
    public function debug()
    {
        // List of available locations.
        $availaibleLocales[] = (Locales::available());

        // // List of installed locations.
        $installedLocalesArray[] =  Locales::installed();

        // // Retrieving a list of protected locales.
        $protectedLocales = Locales::protects();

        $testLocale = 'sp';
        $testLocaleavailible = Locales::isAvailable($testLocale);

        // // The checked locale protecting.
        $testLocaleProtected = Locales::isProtected($testLocale);

        // // Checks whether it is possible to install the language pack.
        $testLocaleInstalled = Locales::isInstalled($testLocale);

        // // Getting the default localization name.: string
        $default = Locales::getDefault();

        // // Getting the fallback localization name.: string
        $fallback = Locales::getFallback();

        // dd($protectedLocales);
        $data = [
            'availaibleLocales' => ($availaibleLocales),
            'protectedLocales' => ($protectedLocales),
            'default' => "default locale: "  . $default,
            'fallback' => "fallback locale: "  . $fallback,
            'testLocale' => "test locale: "  . $testLocale,
            'testLocaleavailible' => "test Locale availible: "  . $testLocaleavailible,
            'testLocaleProtected' => "test Locale Protected: "  . $testLocaleProtected,
            'testLocaleInstalled' => "test Locale Installed: "  . $testLocaleInstalled,

        ];
        return view('debug.lang', compact('data', 'installedLocalesArray'));
    }
}
