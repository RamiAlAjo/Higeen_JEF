@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12 " >
      <div class="card mb-3 ">
        <div class="row no-gutters">
            <div class="col-md-12">
                <div class="card-body">
                    <h5 class="card-title pt-2">Add top image</h5>
                    <form action="{{ route('admin.slider.store') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-english-tab" data-toggle="pill" href="#nav-tabs-english"
                                    role="tab" aria-controls="nav-tabs" aria-selected="true">English</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav-arabic-tab" data-toggle="pill" href="#nav-arabic" role="tab"
                                    aria-controls="nav-arabic" aria-selected="false">Arabic</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav-images-tab" data-toggle="pill" href="#nav-images" role="tab"
                                    aria-controls="nav-images" aria-selected="false">Images</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav-details-tab" data-toggle="pill" href="#nav-details" role="tab"
                                    aria-controls="nav-details" aria-selected="false">Details</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="nav-tabs-english" role="tabpanel" aria-labelledby="pills-english-tab">

                                <div class="form-group">
                                    <label class="form-label" for="title_en">Image Title</label>
                                    <input type="text" class="form-control" name="title_en" id="title_en" placeholder="Title of slider">
                                </div>


                            </div>

                            <div class="tab-pane fade" id="nav-arabic" role="tabpanel" aria-labelledby="nav-arabic-tab">

                                <div class="text-right" dir="rtl">

                                    <div class="form-group">
                                        <label class="form-label" for="title_ar"> عنوان الصورة</label>
                                        <input type="text" class="form-control" name="title_ar" id="title_ar" placeholder="Title of slider">
                                    </div>


                                </div>

                            </div>

                            <div class="tab-pane fade" id="nav-images" role="tabpanel" aria-labelledby="nav-images-tab">

                                <div class="form-group">
                                    <label for="image">image (1492x400)<i class="fa-solid fa-plane"></i></label>

                                    <input id="image" type="file" class="form-control" name="image">
                                </div>

                            </div>

                            <div class="tab-pane fade" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">

                                <div class="form-group">
                                    <label class="form-label" for="url">URL</label>
                                    <input type="text" class="form-control" name="url" id="url" placeholder="url">
                                </div>

                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-dark">Create</button>
                            <button class="btn btn-light">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection
