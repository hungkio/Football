<div class="d-flex align-items-center">
    <div class="mr-3">
        <a href="javascript:void(0)">
            @if ($player->getFirstMediaUrl('player'))
                <img id="image_url"
                    src="{{ $player->getFirstMediaUrl('player') ??
                    '/backend/global_assets/images/placeholders/placeholder.jpg'}}"
                    width="auto" height="50"
                />
            @else
                <img src="{{ $player->photo }}" width="auto" height="50" alt="">
            @endif
        </a>
    </div>
</div>