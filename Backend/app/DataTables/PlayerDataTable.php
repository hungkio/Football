<?php

namespace App\DataTables;

use App\DataTables\Core\BaseDatable;
use App\Domain\Country\Models\Country;
use App\Domain\Player\Models\Player;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class PlayerDataTable extends BaseDatable
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
            ->addColumn('photo', fn (Player $player) => view('admin.players._tablePhoto', compact('player')))
            ->addColumn('action', 'admin.players._tableAction');
            // ->editColumn('created_at', fn (Country $country) => formatDate($country->created_at))
            // ->rawColumns(['action']);
    }

    public function query(Player $model): Builder
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
            Column::make('first_name')->title(__('Tên')),
            Column::make('last_name')->title(__('Họ')),
            Column::make('age')->title(__('Tuổi')),
            Column::make('date_of_birth')->title(__('Ngày sinh')),
            Column::make('place_of_birth')->title(__('Nơi sinh')),
            Column::make('country')->title(__('Quốc gia')),
            Column::make('nationality')->title(__('Quốc tịch')),
            Column::make('height')->title(__('Chiều cao')),
            Column::make('weight')->title(__('Cân nặng')),
            Column::make('injured')->title(__('Chấn thương')),
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
