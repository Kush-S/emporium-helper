<x-headers/>

<div class="container bg-light border rounded mb-5">
  {{-- <div class="p-5 d-flex justify-content-center">
    <h4>Upload zyBooks files here. One file for each week.</h4>
  </div> --}}
  <div class="row py-5">
    <div class="col-lg-4">
      <h4><u>Edit risk calculation variables</u></h4>
      <form>
        <div class="form-group pb-2">
          <label>m</label>
          <input type="text" class="form-control" value="-1.06285">
        </div>
        <div class="form-group pb-2">
          <label>b</label>
          <input type="text" class="form-control" value="124.03443">
        </div>
        <div class="">
          <button type="submit" class="btn btn-danger">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
          <a href="#">reset to default</a>
        </div>
      </form>
    </div>

    <span class="col-lg-6 d-flex align-items-center">
      risk = -1.06285 * grade + 124.03443
    </span>
  </div>

  <div class="row">
    <div class="col-lg-4 pb-5">
      <h4><u>Email template for student notification</u></h4>
      <form>
        <div class="form-group pb-2">
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="6">Dear student,

You are at risk...more words...</textarea>
        </div>
        <div class="">
          <button type="submit" class="btn btn-danger">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
          <a href="#">reset to default</a>
        </div>
      </form>
    </div>
    <div class="offset-md-2 col-lg-6 border">
      <h4><u>Instructors</u></h4>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $owner->name }} (owner)</td>
            <td>{{ $owner->email }}</td>
          </tr>
          @foreach ($instructors as $instructor)
            @if ($instructor->email != $owner->email)
            <tr>
              <td>{{ $instructor->name }}</td>
              <td>{{ $instructor->email }}</td>
              <td><a href="{{ route('settings_remove_instructor', [Request()->id, $instructor->id]) }}" class="btn btn-danger">Remove</a></td>
            </tr>
            @endif
          @endforeach
        </tbody>
      </table>
      <a href="{{ route('settings_add_instructor', Request()->id) }}" class="btn btn-primary">Add new instructor</a>
    </div>
  </div>
</div>
<x-footer/>
