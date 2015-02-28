@extends('layout.fixedtwo')

@section('left')
        <h5>Ad Asset Info</h5>
        {{ Former::hidden('id')->value($formdata['_id']) }}

        {{ Former::text('itemDescription','Description') }}

        {{ Former::text('extURL','Link to URL') }}

        {{ Former::select('status')->options(array('inactive'=>'Inactive','active'=>'Active'))->label('Status') }}

        {{-- Former::select('assetType','Device Type')->options( Assets::getType()->TypeToSelection('type','type',true) ) --}}

        <h5>Advertiser</h5>
        {{ Former::text('merchantName','Merchant')->class('form-control auto_merchant') }}
        {{ Former::text('merchantId','Merchant ID')->class('form-control auto_merchant')->id('merchant-id') }}

        {{ Former::text('tags','Tags')->class('tag_keyword') }}

        {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('right')


        <h5>Images</h5>
        <?php
            $fupload = new Fupload();
        ?>
        {{ $fupload->id('imageupload')->title('Select Picture')->label('Upload Picture')
            ->url('upload/asset')
            ->singlefile(true)
            ->prefix('asset')
            ->multi(false)->make($formdata) }}


@stop

@section('modals')

@stop

@section('aux')

<script type="text/javascript">


$(document).ready(function() {


    $('.pick-a-color').pickAColor();

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

    $('#location').on('change',function(){
        var location = $('#location').val();
        console.log(location);

        $.post('{{ URL::to('asset/rack' ) }}',
            {
                loc : location
            },
            function(data){
                var opt = updateselector(data.html);
                $('#rack').html(opt);
            },'json'
        );

    })

    $('.auto_merchant').autocomplete({
        source: base + 'ajax/merchant',
        select: function(event, ui){
            $('#merchant-id').val(ui.item.id);
        }
    });

    function updateselector(data){
        var opt = '';
        for(var k in data){
            opt += '<option value="' + k + '">' + data[k] +'</option>';
        }
        return opt;
    }


});

</script>

@stop