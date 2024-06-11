<?php
declare(strict_types=1);

namespace App\Domain\Taxonomy\DTO;

use App\Http\Requests\Admin\TaxonUpdateRequest;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

class TaxonUpdateData extends DataTransferObject
{
    public string $name;

    public string $slug;

    public string $description;

    public ?UploadedFile $icon;

    public ?string $meta_title;

    public ?string $meta_description;

    public ?string $meta_keywords;

    public static function fromRequest(TaxonUpdateRequest $request): TaxonUpdateData
    {
        return new self([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description') ?? '',
            'icon' => $request->file('icon'),
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords'),
        ]);
    }

}
