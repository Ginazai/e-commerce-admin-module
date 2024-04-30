<?php
$error = false;
$config = include 'actions/conexion.php';

try {

  if (isset($_POST['categorias'])) {
    $consultaSQL = "SELECT * FROM categories WHERE category LIKE '%" . $_POST['categorias'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM categories";
  }

  $sentencia = $con->prepare($consultaSQL);
  $sentencia->execute();

  $categoria = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['categoria']) ? 'Lista de tickets (' . $_POST['categoria'] . ')' : 'Lista de categorias ';
?>

<?php
if ($error) {

  echo("
    <div class='container mt-2'>
      <div class='row'>
        <div class='col-md-12'>
          <div class='alert alert-danger' role='alert'>
            $error 
          </div>
        </div>
      </div>
    </div>");

}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Categoria</th>
            <th>Accion</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($categoria && $sentencia->rowCount() > 0) {
            foreach ($categoria as $fila) {
              ?>
              <tr>
                <td><?php echo $fila["category_id"]; ?></td>
                <td><?php echo $fila["category"]; ?></td>
                <td>
                  <a href="<?= 'actions/delete/borrar_categoria.php?id=' . $fila["category_id"] ?>">🗑️Borrar</a>
                  <a href="<?= 'actions/edit/editar_categoria.php?id=' . $fila["category_id"] ?>">✏️Editar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>