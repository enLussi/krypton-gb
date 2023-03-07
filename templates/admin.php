<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->getTitle() ?></title>

  <link rel="stylesheet" href="/css/bootstrap-5.2.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/agora.css">
  <?= strlen($this->getStyle()) > 0?'<style>'.file_get_contents($this->getStyle()).'</style>':'' ?>
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" 
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer"
  />

  <script src="/css/bootstrap-5.2.3-dist/js/bootstrap.min.js"></script>

  


</head>
<body>
  <?= $content ?>
</body>
<?= strlen($this->getScript()) > 0?'<script async defer>'.file_get_contents($this->getScript()).'</script>':'' ?>
</html>