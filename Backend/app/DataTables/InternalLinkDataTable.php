<?php

namespace App\DataTables;

use App\DataTables\Core\BaseDatable;
use App\DataTables\Export\MenuExportHandler;
use App\Domain\Menu\Models\InternalLink;
use Illuminate\Contracts\Support\Renderable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Domain\Menu\Models\Menu;

class InternalLinkDataTable extends BaseDatable
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
            ->editColumn('created_at', fn (InternalLink $internalLink) => formatDate($internalLink->created_at))
            ->addColumn('action', 'admin.internal-links._tableAction');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Menu $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(InternalLink $model)
    {
        return $model->newQuery();
    }

    protected function getColumns(): array
    {
        return [
            Column::checkbox(''),
            Column::make('id')->title(__('STT'))->data('DT_RowIndex')->searchable(false),
            Column::make('url')->title(__('URL'))->width('20%'),
            Column::make('created_at')->title(__('Thời gian tạo'))->searchable(false),
            Column::computed('action')
            ->title(__('Tác vụ'))
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
        ];
    }

    protected function getTableButton(): array
    {
        return [
            Button::make('create')->addClass('btn btn-success')->text('<i class="fal fa-plus-circle mr-2"></i>'.__('Tạo mới'))
            ->action("$('#createInternalLink').modal('show')"),
        ];
    }

    protected function getBuilderParameters(): array
    {
        return [
            'order' => [4, 'desc'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Menu_'.date('YmdHis');
    }

    protected function buildExcelFile()
    {
        $this->request()->merge(['length' => -1]);
        $source = app()->call([$this, 'query']);
        $source = $this->applyScopes($source);

        return new MenuExportHandler($source->get());
    }

    public function printPreview(): Renderable
    {
        $this->request()->merge(['length' => -1]);
        $source = app()->call([$this, 'query']);
        $source = $this->applyScopes($source);
        $data = $source->get();
        return view('admin.menus.print', compact('data'));
    }
}
