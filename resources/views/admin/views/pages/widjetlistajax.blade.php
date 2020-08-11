{{ csrf_field() }}
<div class="row">
	@foreach ($list as $widjetKey=>$widjet)
	<!-- One -->
		<div class="col-md-3">
			<div class="col-md-12">
				<b class="d-block">{{$widjet['name']}}</b>
				<a class="btn btn-primary" href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{route('admin.pages.widjetadd',[$pageID,$widjetKey,$position])}}','modal-xl','bg-light', '{{__('Добавить виджет')}}')">Добавить</a>
			</div>
		</div>
	<!-- /.row -->
	@endforeach
</div>