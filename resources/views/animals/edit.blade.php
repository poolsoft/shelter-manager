@extends('layouts/main')
@section('title', 'Edit Animal')

@section('content')
<br>
<h3>Animals</h3>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(!isset($animal))
<p>Incorrect animal id.</p>
@else
<form method="POST" action="{{route('animals.update', ['id' => $animal->id])}}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="animal-number">Animal number</label>
            <input type="text" class="form-control" id="animal-number" name="animal-number"
                value="{{$animal->list_number}}">
        </div>
        <div class="form-group col-md-4">
            <label for="species">Species</label>
            <select class="form-control" id="species" name="species">
                <option>---</option>
                @foreach($species as $speciesItem)
                <option value="{{$speciesItem->id}}" @if($animal->species_id == $speciesItem->id) selected
                    @endif>{{$speciesItem->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="gender">Gender</label>
            <select class="form-control" id="gender" name="gender" value="{{$animal->gender}}">
                <option>---</option>
                <option @if($animal->gender == 'Male') selected @endif>Male</option>
                <option @if($animal->gender == 'Female') selected @endif>Female</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{$animal->name}}">
        </div>
        <div class="form-group col-md-4">
            <label for="size">Size</label>
            <select class="form-control" id="size" name="size">
                <option>---</option>
                <option @if($animal->size == 'Small') selected @endif>Small</option>
                <option @if($animal->size == 'Medium') selected @endif>Medium</option>
                <option @if($animal->size == 'Large') selected @endif>Large</option>
                <option @if($animal->size == 'Very large') selected @endif>Very large</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="microchip">Microchip number</label>
            <input type="text" class="form-control" id="microchip" name="microchip" value="{{$animal->chip_number}}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="breed">Breed</label>
            <select class="form-control" id="breed" name="breed[]" multiple>
                @foreach($species as $speciesItem)
                @if($speciesItem->breeds()->count() > 0)
                <optgroup label="{{$speciesItem->name}}">
                    @foreach($speciesItem->breeds as $breed)
                    <option value="{{$breed->id}}" @if($animal->breeds->contains($breed)) selected @endif>{{$breed->name}}</option>
                    @endforeach
                </optgroup>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="birthdate">Date of Birth</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{$animal->birthdate}}">
            <span style="display: block; text-align: center">or</span>
            <input type="number" class="form-control" id="age-digit" name="age-digit" min="1" value="" style="width: 50%; float: left">
            <select class="form-control" id="age-unit" name="age-unit" style="width: 50%">
                <option>years</option>
                <option>months</option>
                <option>weeks</option>
                <option>days</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="intake-date">Intake Date</label>
            <input type="datetime-local" class="form-control" id="intake-date" name="intake-date"
                value="{{str_replace(' ', 'T', $animal->intake_date)}}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="staff">Responsible staff</label>
            <select class="form-control" id="staff" name="staff">
                <option>---</option>
                @foreach($staff as $staffMember)
                <option value="{{$staffMember->id}}" @if($animal->staff_id == $staffMember->id) selected
                    @endif>{{$staffMember->first_name}} {{$staffMember->last_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="living-area">Living area</label>
            <select class="form-control" id="living-area" name="living-area">
                <option>---</option>
                @foreach($livingAreas as $livingArea)
                <option value="{{$livingArea->id}}" @if($animal->living_area_id == $livingArea->id) selected
                    @endif>{{$livingArea->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="color">Color</label>
            <select class="form-control" id="color" name="color">
                <option>---</option>
                @foreach($colors as $color)
                <option value="{{$color->id}}" @if($animal->color_id == $color->id) selected @endif>{{$color->name}}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="intake-type">Intake type</label>
            <select class="form-control" id="intake-type" name="intake-type">
                @foreach($intakeTypes as $type)
                    <option value="{{$type->id}}" @if($animal->intakeType->id == $type->id) selected @endif>{{$type->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="call">Reference call</label>
            <searchable-select :options="{{json_encode($calls)}}" name="call" placeholder="Reference call" @if(isset($animal->call)) default="{{$animal->call->id}}" @endif/>
        </div>
        <div class="form-group col-md-4">
            <label for="bring-in-person">Person bringing animal in</label>
            <searchable-select :options="{{json_encode($people)}}" name="bring-in-person" display="full_name" placeholder="Person" @if(isset($animal->bringInPerson)) default="{{$animal->bringInPerson->id}}" @endif/>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
            <input type="hidden" name="is-neutered" value="0">
            <input type="checkbox" name="is-neutered" id="is-neutered" {{$animal->is_neutered ? 'checked' : ''}}>
            <label for="is-neutered">Spayed/neutered</label>
        </div>
    </div>
    <div class="form-row">
        <div class="animal-images" style="width: 100%">
            @foreach($animal->images as $image)
            <div class="animal-image-container" style="position: relative; float: left; width: 150px; height: 150px; margin-right: 1em; margin-bottom: 1em">
                <span class="delete-button"
                    style="background-color: #FFF; padding: 2px 8px; position: absolute; x: 0; y: 0; cursor: pointer">x</span>
                <img src="{{Storage::url($image->path)}}" id="{{$image->id}}" class="animal-image" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            @endforeach
            <input type="hidden" id="animal-images-list" name="animal-images-list" value="">
        </div>
    </div>
    <image-upload></image-upload>
    <button type="submit" class="btn btn-success" style="margin: 15px 0; padding: 10px 20px">Save</button>
</form>
@endif
@endsection
@section('scripts')
<script>
    window.addEventListener('load', () => {
        // Attach event handlers to calculate animal images that will be saved
        $('.animal-image-container .delete-button').click(function (event) {
            $(this).parent().remove();
            var imageIds = [];
            $('.animal-images img.animal-image').each(function (event) {
                imageIds.push($(this).attr('id'));
            });
            $('#animal-images-list').val(imageIds.join());
        });

        var imageIds = [];
        $('.animal-images img.animal-image').each(function (event) {
            imageIds.push($(this).attr('id'));
        });
        $('#animal-images-list').val(imageIds.join());

    });

</script>
@endsection
