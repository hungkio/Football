<?php

namespace App\DataTables;

use App\DataTables\Core\BaseDatable;
use App\Domain\Fixture\Models\Fixture;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class FixtureDataTable extends BaseDatable
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
            // ->addColumn('photo', fn (Fixture $fixture) => view('admin.fixtures._tablePhoto', compact('fixture')))
            ->addColumn('action', 'admin.fixtures._tableAction')
            ->editColumn('periods', function (Fixture $fixture){
                $timeStamp = json_decode($fixture->periods)->first;
                if ($timeStamp) {
                    $round1 = Carbon::createFromTimestamp($timeStamp)->format('Y-m-d H:i:s');
                    return $round1;
                }else{
                    return null;
                }
            })
            ->addColumn('periods2', function (Fixture $fixture){
                $timeStamp = json_decode($fixture->periods)->second;
                if ($timeStamp) {
                    $round2 = Carbon::createFromTimestamp($timeStamp)->format('Y-m-d H:i:s');
                    return $round2;
                }else{
                    return null;
                }
            })
            ->editColumn('venue', function (Fixture $fixture){
                $venue = json_decode($fixture->venue)->id;
                return $venue;
            })
            ->editColumn('league', function (Fixture $fixture){
                $league = json_decode($fixture->league)->id;
                return $league;
            })
            ->editColumn('team_away', function (Fixture $fixture){
                $team_away = json_decode($fixture->teams)->away->id;
                return $team_away;
            })
            ->editColumn('team_home', function (Fixture $fixture){
                $team_home = json_decode($fixture->teams)->home->id;
                return $team_home;
            })
            ->editColumn('goals', function (Fixture $fixture){
                $goals = (json_decode($fixture->goals)->home ?? 'đang cập nhật') . ' - ' . (json_decode($fixture->goals)->away ?? 'đang cập nhật');
                return $goals;
            })
            ->rawColumns(['action']);
    }

    public function query(Fixture $model): Builder
    {
        return $model->newQuery();
    }

    protected function getColumns(): array
    {
        return [
            Column::checkbox(''),
            Column::make('id')->title(__('STT'))->data('DT_RowIndex')->searchable(false),
            Column::make('api_id')->title(__('Mã trận')),
            Column::make('referee')->title(__('Trọng tài')),
            Column::make('date')->title(__('Bắt đầu')),
            Column::make('periods')->title(__('Hiệp 1')),
            Column::make('periods2')->title(__('Hiệp 2')),
            Column::make('venue')->title(__('Sân')),
            Column::make('league')->title(__('Giải')),
            Column::make('team_away')->title(__('Đội khách')),
            Column::make('team_home')->title(__('Đội nhà')),
            Column::make('goals')->title(__('tỉ số (Đội nhà - đội khách)' )),
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
