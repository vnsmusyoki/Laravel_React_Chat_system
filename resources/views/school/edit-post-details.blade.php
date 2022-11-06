@extends('layouts.layout')
@section('title', 'School | Update Post')
@section('content')
    {{-- @livewire('admin.create-business') --}}
    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">Edit  Post</h4>
        </div>
        <div class="card-body pt-1">
            <!-- form -->
            <form class="validate-form" method="POST" action="{{ route('schooladmin.updatepost', $post->slug) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-12 col-sm-12 mb-1">
                        <label class="form-label" for="account-retype-new-password">Post Title</label>
                        <div class="input-group form-password-toggle input-group-merge">
                            <input type="text" class="form-control @error('post_title') is-invalid @enderror"
                                value="{{ $post->post_title }}" id="account-retype-new-password" name="post_title"
                                placeholder="" />
                        </div>
                        @error('post_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="col-12 col-sm-12 mb-1">
                        <label class="form-label" for="account-retype-new-password">Post Image <small class="text-success">Optional</small></label>
                        <div class="input-group form-password-toggle input-group-merge">
                            <input type="file" class="form-control @error('post_image') is-invalid @enderror"
                                value="{{ old('post_image') }}" id="account-retype-new-password" name="post_image"
                                placeholder="" />
                        </div>
                        @error('post_image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12 col-sm-12 mb-1">
                        <label class="form-label" for="account-old-password">Post Description</label>
                        <textarea name="post_description" id="editor" cols="30" rows="5" class="form-control">{{ $post->description }}</textarea>
                        @error('post_description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="col-12">
                        <button type="submit" class="btn btn-warning me-1 mt-1">Update Post</button>
                        <button type="reset" class="btn btn-outline-secondary mt-1">Reset</button>
                    </div>
                </div>
            </form>
            <!--/ form -->
        </div>
    </div>
@endsection
