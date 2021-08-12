<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css"  integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <title>TMDB - Listagem</title>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
        <script src="js/main.js"></script>
    </head>
<body>
<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">TMDB</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse d-flex flex-row" id="navbarCollapse">
                <ul class="navbar-nav mr-auto flex-1 w-100">
                    <li class="nav-item active">
                        <a href="index.php" class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="movies.php" class="nav-link" href="#">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a href="movies.php?fav=true" class="nav-link" href="#">Favoritos</a>
                    </li>
                </ul>
                <form class="d-flex flex-row mt-2 mt-md-0" action="buscar.php">
                    <input name="q" class="flex-1 form-control mr-sm-2" type="text" value="<?=isset($_GET['q'])?$_GET['q']:'';?>" placeholder="Pesquisar por algo..." aria-label="Buscar" style="width:200px;">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </nav>
</header>