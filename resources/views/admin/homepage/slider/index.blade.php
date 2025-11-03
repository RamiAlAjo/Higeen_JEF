@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12 " >
      <div class="card mb-3 ">
        <div class="row no-gutters">
            <div class="col-md-12">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <h5 class="card-title pt-2">Top Image</h5>
                        </div>
                        <div class="col-md-6 col-6 text-right">
                            <a href="{{route('admin.slider.create')}}" class="btn btn-primary">Add Image</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">image</th>
                                <th scope="col">url</th>
                                <th scope="col">actions</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($sliders as $slider)
                                    <tr>
                                        <td scope="row">{{ $slider->id }}</td>
                                        <td>{{ $slider->title_en ?? 'No title'}}</td>
                                        <td>
                                            <img src="{{asset($slider->image)}}"width="80" height="80" alt="image">
                                        </td>
                                        <td>{{ $slider->url ?? 'No URL'}}</td>
                                        <td>
                                            <a type="button" class="btn btn-sm btn-info" href="{{ route('admin.slider.edit', $slider->id) }}">edit</a>
                                            <form action="{{ route('admin.slider.destroy', $slider->id) }}" method="POST">
                                                <a type="Button"class="btn btn-sm btn-danger" data-toggle='modal' data-target="#staticBackdrop{{ $slider->id }}">Delete
                                                </a>
                                                @method('DELETE')
                                                @csrf
                                                    <div class="modal fade" id="staticBackdrop{{ $slider->id }}" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">delete</h5>
                                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                        are you sure that you want to delete {{ $slider->title_en }}?
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                                                        <button type="Delete" class="btn btn-sm btn-danger">yes</button>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection
