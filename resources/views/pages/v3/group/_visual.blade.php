<form method="post" action="{{route('group.visual.save', $group->id)}}" enctype="multipart/form-data">
    {{csrf_field()}}

    @component('partials.v3.frame', [
        'title' => 'Visual',
        'footer' => '<small>Max. 500KB size | Supported: png, jpg, jpeg, gif</small>'
    ])
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Background image</label>
                    <p>
                        Set a custom background image for your group.
                    </p>
                    <input class="form-control" type="file" name="background">
                </div>
            </div>
            <div class="col-md-6">
                <div class="thumbnail">
                    <img src="{{$group->backgroundImage()}}" style="max-width:200px; max-height:200px; height:auto; width:100%;">
                </div>
            </div>
        </div>

        <br>

        @include('partials.v3.button', [
            'type' => 'submit',
            'element' => 'button',
            'title' => translate('upload', 'Upload'),
            'class' => 'center'
        ])

    @endcomponent

</form>