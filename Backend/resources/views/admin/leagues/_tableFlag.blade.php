<div class="d-flex align-items-center">
    <div class="mr-3">
        <a href="javascript:void(0)">
            @if ($league->getFirstMediaUrl('league'))
                <img id="image_url"
                    src="{{ $league->getFirstMediaUrl('league') ??
                    '/backend/global_assets/images/placeholders/placeholder.jpg'}}"
                    width="auto" height="50"
                />
            @else
                <img src="{{ $league->logo }}" width="auto" height="50" alt="">
            @endif
        </a>
    </div>
</div>