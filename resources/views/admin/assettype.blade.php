@extends('admin.master')
@section('content')
<style>
    .container{
        width: 600px;
        margin-top: 20px;
        padding: 20px;
        
    }
</style>

<div class="container border shadow mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="text-center btn btn-dark ">Asset Type</div>

                <div class="card-body">
                    @if(Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <form method="POST" action="{{ route('postassettype') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="type" class="col-md-4 col-form-label text-md-right b">Asset Type</label>

                            <div class="col-md-8">
                                <input id="type" type="text" class="form-control" name="type">
                                @if($errors->has('type'))
                            <div class="alert alert-danger">{{$errors->first('type')}}</div>
                            @endif
                            </div>
                           
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Asset Description</label>

                            <div class="col-md-8">
                                <textarea id="description"  class="form-control" name="description">
                                </textarea>  
                                @if($errors->has('description'))
                            <div class="alert alert-danger">{{$errors->first('description')}}</div>
                            @endif
                            </div>
                           
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-block btn-dark">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
