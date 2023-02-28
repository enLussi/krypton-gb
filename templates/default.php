<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->getTitle() ?></title>

  <link rel="stylesheet" href="/css/bootstrap-5.2.3-dist/css/bootstrap.min.css">
  <?= strlen($this->getStyle()) > 0?'<style>'.file_get_contents($this->getStyle()).'</style>':'' ?>
  <script src="/css/bootstrap-5.2.3-dist/js/bootstrap.min.js"></script>

</head>
<body>
  <?= $content ?>
</body>
<?= strlen($this->getScript()) > 0?'<script async defer>'.file_get_contents($this->getScript()).'</script>':'' ?>
</html>