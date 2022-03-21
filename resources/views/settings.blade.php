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
      @if ($classroom->term == 'Spring')Sp'
      @elseif ($classroom->term == 'Fall')Fa'
      @elseif ($classroom->term == 'Summer')Su'
      @endif
      {{ substr($classroom->year, -2) }}
    </div>
  </div>
</div>

<div class="container bg-white border rounded mb-5">
  <div class="row pt-3">
    <div class="col-md-5">
      <div><h3>Edit risk calculation variables</h3></div>
      <div>These variables are used to calculate the risk for this classroom. The calculation is<br>
      risk = -m * grade + b</div>
    </div>
    <div class="col-md-7">
      <div class="card">
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

  <div class="row pt-3">
    <div class="col-md-5">
      <div><h3>Email template for student notifications</h3></div>
      <div>This email template is used when sending a student a notification from this app. This template is specific to this classroom.</div>
    </div>
      <div class="col-md-7">
        <div class="card">
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

  <div class="row py-2">
    <div class="col-md-5">
      <div><h3>Add or remove instructors</h3></div>
      <div>Instructors who have access to this classroom. Only whitelisted instructors will be available to access classrooms, regardless if they are added to a classroom.</div>
    </div>
    <div class="col-md-7">
      <div class="card">
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
