<?php

namespace App\DataTables;

use App\DataTables\Core\BaseDatable;
use App\Domain\Country\Models\Country;
use App\Domain\League\Models\League;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class LeagueDataTable extends BaseDatable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('logo', fn (League $league) => view('admin.leagues._tableFlag', compact('league')))
            ->addColumn('action', 'admin.leagues._tableAction')
            ->addColumn('shown_on_country_standing', fn (League $league) => view('admin.leagues._tableBXH', compact('league')))
            ->addColumn('popular', fn (League $league) => view('admin.leagues._tablePopular', compact('league')))
            ->addColumn('priority', fn (League $league) => view('admin.leagues._tablePriority', compact('league')))
            ->rawColumns(['shown_on_country_standing','popular','priority','action'])
            ;
            // ->editColumn('created_at', fn (Country $country) => formatDate($country->created_at))
            // ->rawColumns(['action']);
    }

    public function query(League $model): Builder
    {
        return $model->newQuery();
    }

    protected function getColumns(): array
    {
        return [
            Column::checkbox(''),
            Column::make('id')->title(__('STT'))->data('DT_RowIndex')->searchable(false),
            Column::make('api_id')->title(__('Mã giải')),
            Column::make('name')->title(__('Tên')),
            Column::make('type')->title(__('Kiểu')),
            Column::make('country_code')->title(__('Mã quốc gia')),
            Column::computed('popular')
                ->title(__('BXH QG'))
                ->exportable(false)
                ->printable(false)
                ->width(20)
                ->addClass('text-center'),
            Column::computed('shown_on_country_standing')
                ->title(__('Giải Hot'))
                ->exportable(false)
                ->printable(false)
                ->width(20)
                ->addClass('text-center'),
            Column::computed('priority')
                ->title(__('Mức Độ ƯT'))
                ->exportable(false)
                ->printable(false)
                ->width(20)
                ->addClass('text-center'),
            Column::make('logo')->title(__('Logo')),
            Column::computed('action')
                ->title(__('Tác vụ'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),

        ];
    }

    protected function getBuilderParameters(): array
    {
        return [
            'order' => [6, 'desc'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'League_'.date('YmdHis');
    }

    protected function getTableButton(): array
    {
        return [
            // Button::make('create')->addClass('btn btn-success d-none')->text('<i class="fal fa-plus-circle mr-2"></i>'.__('Tạo mới')),
            Button::make('export')->addClass('btn btn-primary')->text('<i class="fal fa-download mr-2"></i>'.__('Xuất')),
            Button::make('print')->addClass('btn bg-primary')->text('<i class="fal fa-print mr-2"></i>'.__('In')),
            Button::make('reset')->addClass('btn bg-primary')->text('<i class="fal fa-undo mr-2"></i>'.__('Thiết lập lại')),
            Button::make('save')->addClass('btn btn-primary')->text('<i class="fal fa-save mr-2"></i>'.__('Lưu thiết lập')),
        ];
    }

    // protected function buildExcelFile()
    // {
    //     $this->request()->merge(['length' => -1]);
    //     $source = app()->call([$this, 'query']);
    //     $source = $this->applyScopes($source);

    //     return new CommentExportHandler($source->get());
    // }

    // public function printPreview(): Renderable
    // {
    //     $this->request()->merge(['length' => -1]);
    //     $source = app()->call([$this, 'query']);
    //     $source = $this->applyScopes($source);
    //     $data = $source->get();
    //     return view('admin.comments.print', compact('data'));
    // }
}
