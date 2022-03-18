<x-headers/>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif
      @if (session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif
    </div>
  </div>
</div>

<div class="container d-flex justify-content-center">
  <div class="row">
    <div class="pt-1 h4 pb-2 text-white bg-info rounded-pill">
      {{ $classroom->number }}
      (@if ($classroom->term == 'Spring')Sp'
      @elseif ($classroom->term == 'Fall')Fa'
      @elseif ($classroom->term == 'Summer')Su'
      @endif
      {{ substr($classroom->year, -2) }})
    </div>
  </div>
</div>

<div class="container bg-white border rounded mb-5">
  <div class="row py-5">
    <div class="col-md-5">
      <strong>Edit risk calculation variables</strong><br>
      These variables are used to calculate the risk for this classroom. The calculation is<br>
      risk = -m * grade + b
    </div>
    <div class="col-md-7">
      <div class="card">
        <h3 class="card-header">Variables</h3>
        <div class="card-body">
          <form>
            <div class="form-group pb-2">
              <label>m</label>
              <input type="text" class="form-control" value="-1.06285">
            </div>
            <div class="form-group pb-2">
              <label>b</label>
              <input type="text" class="form-control" value="124.03443">
            </div>
            <div class="float-end">
              <a href="#">reset to default</a>
              <button type="submit" class="btn btn-danger">Cancel</button>
              <button type="submit" class="btn btn-primary px-3">Save</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <div class="row py-5">
    <div class="col-md-5">
      <strong>Email template for student notifications</strong><br>
      This email template is used when sending a student a notification from this app. This template is specific to this classroom.
    </div>
      <div class="col-md-7">
        <div class="card">
          <h3 class="card-header">Email Template</h3>
          <div class="card-body">
            <form>
              <div class="form-group pb-2">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6">Dear student,

    You are at risk...more words...</textarea>
              </div>
              <div class="float-end">
                <a href="#">reset to default</a>
                <button type="submit" class="btn btn-danger">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>

  <div class="row pb-4">
    <div class="col-md-5">
      <strong>Add or remove instructors</strong><br>
      Instructors who have access to this classroom. Only whitelisted instructors will be available to access classrooms, regardless if they are added to a classroom.
    </div>
    <div class="col-md-7">
      <div class="card">
        <h3 class="card-header">Instructors</h3>
        <div class="card-body">
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
  </div>

</div>
<x-footer/>
