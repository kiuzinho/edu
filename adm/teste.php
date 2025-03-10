<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Choices Example</title>
  <!-- Inclua os arquivos CSS necessários -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
</head>
<body>
  <div class="form-group row">
    <label class="col-form-label col-lg-4 col-sm-12 text-lg-end">With remove button</label>
    <div class="col-lg-6 col-md-11 col-sm-12">
      <select
        class="form-control"
        name="choices-multiple-remove-button"
        id="choices-multiple-remove-button"
        multiple
      >
        <option value="Choice 1">Choice 1</option>
        <option value="Choice 2">Choice 2</option>
        <option value="Choice 3">Choice 3</option>
        <option value="Choice 4">Choice 4</option>
      </select>
    </div>
  </div>

  <!-- Inclua os arquivos JavaScript necessários -->
  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        removeItemButton: true
      });
    });
  </script>
</body>
</html>