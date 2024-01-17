@extends('layouts.master')

@section('title', 'home')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-2 mt-5">
            <div class="card">
                <div class="card-header bg-info">
                    <h6 class="text-white">How to Install And Use CKEditor In Laravel? - ItSolutionStuff.com</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control"/>
                        </div>  
                        <div class="form-group">
                            <label><strong>Description :</strong></label>
                            <textarea class="ckeditor form-control" name="description"></textarea>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary">Left</button>
        <button type="button" class="btn btn-primary">Middle</button>
        <button type="button" class="btn btn-primary">Right</button>
        <i class="fa fa-user" aria-hidden="true"></i>
      </div>
</div>  

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // alert('ok');
    //    $('.ckeditor').ckeditor();
    });
</script>

@endsection