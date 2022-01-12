<x-headers/>

<div class="container bg-light">
  <div class="p-1 d-flex justify-content-center">
    <h4>Variables for Risk Calculation Model</h4>
  </div>
  <div class="d-flex justify-content-center">
    <div class="row col col-md-3">
      <form class="">
        <div class="mb-3">
          <label for="participationModifier" class="form-label">Participation modifier</label>
          <input type="number" class="form-control" id="participationModifier" aria-describedby="participationModifierField">
          <div id="participationModifierField" class="form-text">Multiple participation score with this.</div>
        </div>
        <div class="mb-3">
          <label for="participationMax" class="form-label">Participation max risk</label>
          <input type="number" class="form-control" id="participationMax" aria-describedby="participationMaxField">
          <div id="participationMaxField" class="form-text">Max participation risk allowed.</div>
        </div>
        <button class="btn btn-primary" type=submit>Save variables</button>
      </form>
    </div>
  </div>
</div>
