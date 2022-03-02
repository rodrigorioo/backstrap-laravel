<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

use Illuminate\Support\Facades\App;

class Language {

    public static function getLanguageSelected ($request) {

        $languages = config('backstrap_laravel.languages');

        if($languages && count($languages) > 0) {

            $query = $request->query;

            // If has a set language request attribute
            if($query->has('set_language')) {
                $languageName = $languages[$query->get('set_language')];

                return [
                    'language' => $query->get('set_language'),
                    'name' => $languageName,
                ];
            } else {

                // If not, set the language to app locale
                $languageName = $languages[App::getLocale()];

                return [
                    'language' => App::getLocale(),
                    'name' => $languageName,
                ];
            }

        }

        return [];
    }
}