<div>

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownCRUDLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ $languageSelected['name'] }}
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownCRUDLanguage">
            @foreach(config('backstrap_laravel.languages') as $language => $languageName)

                @if($language != $languageSelected['language'])
                    <a class="dropdown-item" href="{{ URL::current() }}?set_language={{ $language }}">{{ $languageName }}</a>
                @endif
            @endforeach
        </div>
    </div>

</div>