<div class="d-flex align-items-center">
    <div class="mr-3">
        <a href="javascript:void(0)">
            @if ($team->getFirstMediaUrl('team'))
                <img id="image_url"
                    src="{{ $team->getFirstMediaUrl('team') ??
                    '/backend/global_assets/images/placeholders/placeholder.jpg'}}"
                    width="auto" height="50"
                />
            @else
                <img src="{{ $team->logo }}" width="auto" height="50" alt="">
            @endif
        </a>
    </div>
</div>