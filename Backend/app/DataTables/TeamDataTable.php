<?php

namespace App\DataTables;

use App\DataTables\Core\BaseDatable;
use App\Domain\Country\Models\Country;
use App\Domain\Team\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class TeamDataTable extends BaseDatable
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
            ->addColumn('logo', fn (Team $team) => view('admin.teams._tableFlag', compact('team')))
            ->addColumn('action', 'admin.teams._tableAction');
            // ->editColumn('created_at', fn (Country $country) => formatDate($country->created_at))
            // ->rawColumns(['action']);
    }

    public function query(Team $model): Builder
    {
        return $model->newQuery();
    }

    protected function getColumns(): array
    {
        return [
            Column::checkbox(''),
            Column::make('id')->title(__('STT'))->data('DT_RowIndex')->searchable(false),
            Column::make('name')->title(__('Tên')),
            Column::make('code')->title(__('Mã')),
            Column::make('country')->title(__('Quốc Gia')),
            Column::make('national')->title(__('Là đội tuyển quốc gia')),
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
            'order' => [5, 'desc'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Countries_'.date('YmdHis');
    }

    protected function getTableButton(): array
    {
        return [
            Button::make('create')->addClass('btn btn-success d-none')->text('<i class="fal fa-plus-circle mr-2"></i>'.__('Tạo mới')),
            Button::make('export')->addClass('btn btn-primary')->text('<i class="fal fa-download mr-2"></i>'.__('Xuất')),
            Button::make('print')->addClass('btn bg-primary')->text('<i class="fal fa-print mr-2"></i>'.__('In')),
            Button::make('reset')->addClass('btn bg-primary')->text('<i class="fal fa-undo mr-2"></i>'.__('Thiết lập lại')),
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
