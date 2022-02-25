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
        <div class="float-end">
          <button type="submit" class="btn btn-danger">Reset</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>

    <span class="col-lg-6 pb-5 align-middle">
      risk = -1.06285 * grade + 124.03443
    </span>
  </div>

  <div class="">
    <div class="col-lg-4 pb-5">
      <h4><u>Email template for student notification</u></h4>
      <form>
        <div class="form-group pb-2">
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="6">Dear student,
            
You are at risk...more words...</textarea>
        </div>
        <div class="float-end">
          <button type="submit" class="btn btn-danger">Reset</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
