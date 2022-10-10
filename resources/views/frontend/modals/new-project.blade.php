{{-- New project modal  --}}
<div class="modal fade" tabindex="-1" role="dialog" id="newProjectModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form class="_form" action="" method="post">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label>@lang('Project title')</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control input-lg">
                    </div>


                    <div class="mt-10 pb-10 text-right">
                        <a class="btn btn-grey btn-md" data-dismiss="modal">@lang('Cancel')</a>
                        <button type="submit" class="btn btn-primary btn-md">
                            <i class="ion-android-done-all mr-5"></i>
                            @lang('Continue')
                        </button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
