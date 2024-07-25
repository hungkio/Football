<div class="d-flex align-items-center">
    <div class="mr-3">
        <a href="javascript:void(0)">
            @if ($coach->getFirstMediaUrl('coach'))
                <img id="image_url"
                    src="{{ $coach->getFirstMediaUrl('coach') ??
                    '/backend/global_assets/images/placeholders/placeholder.jpg'}}"
                    width="auto" height="50"
                />
            @else
                <img src="{{ $coach->photo }}" width="auto" height="50" alt="">
            @endif
        </a>
    </div>
</div>