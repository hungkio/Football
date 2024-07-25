<?php

namespace App\DataTables;

use App\DataTables\Core\BaseDatable;
use App\Domain\Coach\Models\Coach;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class CoachDataTable extends BaseDatable
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
            ->addColumn('photo', fn (Coach $coach) => view('admin.coaches._tablePhoto', compact('coach')))
            ->addColumn('action', 'admin.coaches._tableAction');
    }

    public function query(Coach $model): Builder
    {
        return $model->newQuery();
    }

    protected function getColumns(): array
    {
        return [
            Column::checkbox(''),
            Column::make('id')->title(__('STT'))->data('DT_RowIndex')->searchable(false),
            Column::make('api_id')->title(__('Mã số')),
            Column::make('name')->title(__('Tên đầy đủ')),
            Column::make('firstname')->title(__('Tên')),
            Column::make('lastname')->title(__('Họ')),
            Column::make('age')->title(__('Tuổi')),
            Column::make('date_of_birth')->title(__('Ngày sinh')),
            Column::make('place_of_birth')->title(__('Nơi sinh')),
            Column::make('country')->title(__('Quốc gia')),
            Column::make('nationality')->title(__('Quốc tịch')),
            Column::make('height')->title(__('Chiều cao')),
            Column::make('weight')->title(__('Cân nặng')),
            Column::make('team_id')->title(__('ID đội bóng')),
            // Column::make('career')->title(__('Sự nghiệp')),
            Column::make('photo')->title(__('Ảnh')),
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
