<div class="flex flex-col pt-2">
    <h4 class="flex bg-slate-400 p-2 text-gray-800 w-full rounded-t">
        <span class="inline-flex">
            <i data-fa-symbol="wikipedia" class="fa-brands fa-wikipedia-w fa-fw"></i>
            <svg class="mt-1 h-4 w-4">
                <use xlink:href="#wikipedia"></use>
            </svg>&nbsp;
            @ucfirst(__('app.wikipedia'))
        </span>
    </h4>
    <div class="flex bg-slate-200 p-2 text-black w-full">
        <p class="text-justify">
            @if(!is_null($wikipedia))
            {{ $wikipedia->wikipedia_text }}
            @else
            @ucfirst(__('app.no_wikipedia'))
            @endif
        </p>
    </div>
    @if(!is_null($wikipedia))
    <div class="flex justify-end bg-slate-200 p-2 w-full rounded-b">
        <a href="{{ $wikipedia->wikipedia_link }}" target="_blank"
           class="flex grow-0 hover:bg-gray-800 p-3 text-gray-800 hover:text-white text-sm rounded">
            @ucfirst(__('app.wikipedia'))
        </a>
    </div>
    @endif
</div>
