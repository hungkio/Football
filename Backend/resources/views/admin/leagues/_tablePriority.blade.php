<form class="list-icons" action="{{route('admin.api.league.priority.save')}}" method="post">
    <input type="hidden" name="league_id" value="{{$league->id}}">

    <div class="form-group mx-sm-3 mb-2">
        <input type="text" class="form-control" style="padding: 5px; width: 60px; text-align: center" name="priority" value="{{$league->priority ?? null}}">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Lưu</button>
</form>
