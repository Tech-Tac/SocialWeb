@extends('layouts.app')

@section('content')
  <div class="card mb-3">
    <div class="card-body">
      @if ($errors->any())
        <div class="alert alert-danger">
          Something went wrong, please try again.
        </div>
      @endif
      <form action="{{ isset($group) ? route('groups.update', $group) : route('groups.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @if (isset($group))
          @method('PUT')
        @endif
        <fieldset>
          <legend>Group Info</legend>
          <div class="mb-3">
            <label for="name" class="form-label"><i class="bi bi-bookmark-fill"></i> Name</label>
            <input type="text" class="form-control" name="name" maxlength="255" required
              value="{{ $group->name ?? '' }}">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label"><i class="bi bi-text-paragraph"></i> Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" maxlength="1043">{{ $group->description ?? '' }}</textarea>
          </div>
          <div class="mb-3">
            <label for="icon" class="form-label"><i class="bi bi-image"></i> Icon</label>
            <div class="row">
              <div class="col-auto">
                <img
                  src="{{ isset($group) ? asset('images/' . ($group->icon ?? 'group.svg')) : asset('images/group.svg') }}"
                  id="image" class="img-thumbnail" style="width:10em;height:10em;">
              </div>
              <div class="col">
                <input type="file" class="form-control" name="icon" id="icon" accept="image/*"><br>
                <input type="hidden" id="clear_icon" name="clear_icon" value="0">
                <button class="btn btn-danger" id="clear_btn" type="button"><i class="bi bi-x-lg"></i>Remove</button>
              </div>
            </div>
          </div>
        </fieldset>
        <div class="text-center">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-check-lg"></i>
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>
  @if (isset($group))
    <div class="card">
      <div class="card-body">

        <fieldset>
          <legend>Danger Zone</legend>
          <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm_modal">
            <i class="bi bi-person-x-fill"></i>
            Delete Group
          </button>
        </fieldset>

        <div class="modal fade" id="confirm_modal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h5 class="alert alert-warning">
                  Are you sure about that?
                </h5>
                <p>
                  Are you sure you want to delete this group?
                  All posts and comments are going to be deleted forever!
                  There is no going back!
                  You have been warned!
                </p>
              </div>
              <div class="modal-footer">
                <form action="{{ route('groups.destroy', $group) }}" method="POST">
                  @method('DELETE')
                  @csrf
                  <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                    Never mind</button>
                  <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash-fill"></i>
                    Delete Anyway</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection
@push('scripts')
  <script>
    window.addEventListener("load", () => {
      const preview = document.getElementById("image");
      const input = document.getElementById("icon");
      const clearImage = document.getElementById('clear_icon');

      input.addEventListener("input", () => {
        const file = input.files[0];

        if (file) {
          preview.src = URL.createObjectURL(file);
          clearImage.value = 0;
        }
      });

      document.getElementById("clear_btn").addEventListener("click", clear);

      function clear() {
        clearImage.value = 1;
        input.value = null;
        input.files = null;
        preview.src = "{{ asset('images/group.svg') }}";
      }
    });
  </script>
@endpush
