<x-headers/>

<div class="container bg-light border rounded">
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
          <button type="submit" class="btn btn-danger">Reset</button>
          <button type="submit" class="btn btn-primary">Save</button>
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
          <button type="submit" class="btn btn-danger">Reset</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
    <div class="offset-md-2 col-lg-6 border">
      <h4><u>Classroom members</u></h4>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Mark Jacob</td>
            <td>mjacob@bgsu.edu</td>
          </tr>
          <tr>
            <td>Otto Thornton</td>
            <td>othorn@bgsu.edu</td>
          </tr>
        </tbody>
      </table>
      <button type="submit" class="btn btn-primary">Add new member</button>
    </div>
  </div>
</div>
