<?php

namespace App\DataTables;

use App\DataTables\Core\BaseDatable;
use App\Domain\Contact\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class ContactDataTable extends BaseDatable
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
            ->addColumn('user', fn (Contact $contact) => view('admin.contacts._tableTitle', compact('contact')))
            ->addColumn('message', fn (Contact $contact) => view('admin.contacts._tableMessage', compact('contact')))
            ->filterColumn('user', function($query, $keyword) {
                $query->orWhere('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%");
            })
            ->filterColumn('message', function($query, $keyword) {
                $query->where('message', 'like', "%{$keyword}%");
            })
            ->orderColumn('user',
                fn($query, $direction) => $query->orderByRaw("CONCAT(first_name, ' ', last_name) $direction")
            )
            ->orderColumn('message', 'message $1')
            ->editColumn('created_at', fn (Contact $contact) => formatDate($contact->created_at));
    }

    public function query(Contact $model): Builder
    {
        return $model->newQuery();
    }

    protected function getColumns(): array
    {
        return [
            Column::make('id')->title(__('STT'))->data('DT_RowIndex')->searchable(false),
            Column::make('user')->title(__('Họ Tên'))->searchable(true),
            Column::make('email')->title(__('Email'))->searchable(true),
            Column::make('phone')->title(__('Số điện thoại'))->searchable(true),
            Column::make('title')->title(__('Tiêu Đề'))->searchable(true),
            Column::make('message')->title(__('Nội dung'))->searchable(true),
            Column::make('created_at')->title(__('Thời gian tạo'))->searchable(true),
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
        return 'Contact_'.date('YmdHis');
    }

    protected function getTableButton(): array
    {
        return [
            Button::make('export')->addClass('btn bg-blue')->text('<i class="fal fa-download mr-2"></i>'.__('Xuất')),
            Button::make('print')->addClass('btn bg-blue')->text('<i class="fal fa-print mr-2"></i>'.__('In')),
            Button::make('reset')->addClass('btn bg-blue')->text('<i class="fal fa-undo mr-2"></i>'.__('Thiết lập lại')),
        ];
    }
}
