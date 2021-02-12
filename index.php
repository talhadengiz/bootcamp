<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

<?php
error_reporting(0);
include('config.php');
include('todolist.php');

$app = new TodoList(date('Ymd'));

$todolist = $app->getTodos();
$reqMethod = $_SERVER['REQUEST_METHOD'];

switch ($reqMethod) {
    case 'POST':
        $app->add();
        break;
    case 'GET':
        if ($_GET['action'] === 'delete' && !empty($_GET['id'])) {
            $app->delete($_GET['id']);
        } elseif ($_GET['action'] === 'update' && !empty($_GET['id'])) {
            $app->update($_GET['id'], $_GET['newTodo']);
        } elseif ($_GET['action'] === 'status' && !empty($_GET['id'])) {
            $app->statusChange($_GET['id']);
        }
        break;
}

$todolist = $app->getTodos();
?>

<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-10">
        <form action="/index.php" method="post">
            <div class="input-group">
                <input type="text" class="form-control" name="mytodo">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    <div class="row justify-content-center align-items-center">
        <div class="col-md-10">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">My Todo List</th>
            </tr>
            </thead>
            <tbody>
            <?php $num = 0;
            foreach ($todolist as $k => $v) {
                $num++;
                ?>
                <tr>
                    <th scope="row"><?= $num; ?></th>
                    <td><?php echo $v; ?></td>
                    <td>
                        <form action="/index.php">
                            <a href="/index.php?action=status&id=<?php echo($k + 1); ?>">
                                <button type="button" class="btn btn-success">Finish</button>
                            </a>
                            <a href="/update.php?id=<?php echo($k + 1); ?>">
                                <button type="button" class="btn btn-primary">Edit</button>
                            </a>
                            <!--<a href="/index.php?action=update&id=<?php echo($k + 1); ?>">
                                    <button type="button" class="btn btn-primary">Edit</button>
                                </a>-->
                            <a href="/index.php?action=delete&id=<?php echo($k + 1); ?>">
                                <button type="button" class="btn btn-danger">Delete</button>
                            </a>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>
</html>