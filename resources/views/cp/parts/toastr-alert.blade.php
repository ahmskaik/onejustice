@if(isset($errors) && count($errors)>0)
    <script>
        jQuery(document).ready(function () {
            toastr.options.positionClass = @if(isset($position)) "{{$position}}"
            @else "toast-top-right" @endif;
            toastr.error("{{$errorMessage ??('The Number of Errors: '.(isset($errors) && $errors ? sizeof($errors->all()) : 0))}}", 'Check Errors Below');
        });
    </script>
@endif

@if (\Session::has('success'))
    <script>
        jQuery(document).ready(function () {
            toastr.options.positionClass = @if(isset($position)) "{{$position}}"
            @else "toast-top-right" @endif;
            toastr.success('{{ \Session::get('success') }}');
        });
    </script>
@endif
