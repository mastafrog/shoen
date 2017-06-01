<dic class="container">
<form class="form-horizontal">
<fieldset>

<legend>Neue Reise Anlegen/Edit</legend>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Text Input</label>  
  <div class="col-md-4">
  <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="form-control input-md">
  <span class="help-block">help</span>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="kurzbeschreibung">Kurzbeschreibung</label>  
  <div class="col-md-4">
  <input id="kurzbeschreibung" name="kurzbeschreibung" type="text" placeholder="" class="form-control input-md" required="">
  </div>
</div>
  
<div class="form-group">
  <label class="col-md-4 control-label" for="beschreibung">Beschreibung</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="beschreibung" name="beschreibung"></textarea>
  </div>
</div>
  
<div class="form-group">
  <label class="col-md-4 control-label" for="beschreibung">Begin</label>
  <div class="col-md-4">                     
         <input type="text" id="begin">
  </div>
</div>
  
<div class="form-group">
  <label class="col-md-4 control-label" for="beschreibung">Ende</label>
  <div class="col-md-4">                     
    <input type="text" id="ende">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="picture">Region</label>
  <div class="col-md-4">
    <select id="picture" name="region" class="form-control">
      <option value="1">Option one</option>
      <option value="2">Option two</option>
    </select>
  </div>
</div>
  
</fieldset>
</form>
</div>