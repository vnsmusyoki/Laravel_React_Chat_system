@extends('layouts.layout')
@section('title', 'Admin | Edit  School Student')
@section('content')
    {{-- @livewire('admin.create-business') --}}
    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">Update Student Record</h4>
        </div>
        <div class="card-body pt-1">
            <!-- form -->
            <form class="validate-form" method="POST" action="{{ route('admin.updatestudent', $bsn->slug) }}">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-12 col-sm-3 mb-1">
                        <label class="form-label" for="account-retype-new-password">Student Full Names</label>
                        <div class="input-group form-password-toggle input-group-merge">
                            <input type="text" class="form-control @error('student_full_name') is-invalid @enderror"
                                value="{{ $bsn->studentuser->name }}" id="account-retype-new-password"
                                name="student_full_name" placeholder="" />
                        </div>
                        @error('student_full_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 col-sm-3 mb-1">
                        <label class="form-label" for="account-retype-new-password">Phone Number</label>
                        <div class="input-group form-password-toggle input-group-merge">
                            <input type="number" class="form-control @error('phone_number') is-invalid @enderror"
                                value="{{ $bsn->studentuser->phone_number }}" id="account-retype-new-password" name="phone_number"
                                placeholder="" />
                        </div>
                        @error('phone_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 col-sm-3 mb-1">
                        <label class="form-label" for="account-retype-new-password">Email Address</label>
                        <div class="input-group form-password-toggle input-group-merge">
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                value="{{ $bsn->studentuser->email }}" id="account-retype-new-password" name="email"
                                placeholder="" />
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 col-sm-3 mb-1">
                        <label class="form-label" for="account-retype-new-password">School Name</label>
                        <div class="input-group form-password-toggle input-group-merge">

                                <select name="school_name" id="account-retype-new-password" class="form-control">
                                    <option value="">click to select </option>
                                    @foreach ($schools as $school)
                                    <option value="{{ $school->id }}" {{ ($bsn->school_id === $school->id) ? 'selected' : ''}}>{{ $school->school_name }}</option>
                                    @endforeach
                                </select>
                        </div>
                        @error('school_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12 col-sm-12 mb-1">
                        <label class="form-label" for="email">Home Location</label>
                        <input type="text" id="address-input" name="address_address" value="{{ $bsn->location_address }}"
                            class="form-control map-input form-control-solid @error('address_address') is-invalid @enderror">
                        @error('address_address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input type="hidden" name="address_latitude" id="address-latitude" value="{{ $bsn->latitude }}" />
                        <input type="hidden" name="address_longitude" id="address-longitude" value="{{ $bsn->longitude }}" />

                        <div id="address-map-container" style="width:100%;height:400px; ">
                            <div style="width: 100%; height: 100%" id="address-map"></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-warning me-1 mt-1">Update Student</button>
                        <button type="reset" class="btn btn-outline-secondary mt-1">Discard</button>
                    </div>
                </div>
            </form>
            <!--/ form -->
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize"
        async defer></script>
    <script src="{{ asset('app-assets/js/mapInput.js') }}"></script>
@stop
