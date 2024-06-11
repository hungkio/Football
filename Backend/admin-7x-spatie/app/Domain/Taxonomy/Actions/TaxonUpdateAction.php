<?php

declare(strict_types=1);

namespace App\Domain\Taxonomy\Actions;

use App\Domain\Taxonomy\DTO\TaxonUpdateData;
use App\Domain\Taxonomy\Models\Taxon;
use Illuminate\Support\Facades\DB;

class TaxonUpdateAction
{
    public function execute(Taxon $taxon, TaxonUpdateData $data): void
    {
        DB::transaction(function () use ($taxon, $data){
            $taxon->name = $data->name;
            $taxon->slug = $data->slug;
            $taxon->description = $data->description;
            $taxon->meta_title = $data->meta_title;
            $taxon->meta_description = $data->meta_description;
            $taxon->meta_keywords = $data->meta_keywords;

            $taxon->save();

            if (!empty($data->icon)) {
                $taxon->addMedia($data->icon)->toMediaCollection('icon');
            }
        });
    }
}
