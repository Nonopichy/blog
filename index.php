<?php
$conn = mysqli_connect("127.0.0.1", "root", "Strength", "blog");
function showPostHome($conn, $row){
    $autor = mysqli_fetch_assoc(mysqli_query ( $conn, "select * from `usuarios` where id = '".$row['autor']."';" ));
    echo '<div onclick="goPost('.$row['id'].')" class="home-post card text-center" style="margin: 5; width: 25rem;">';
    if($row['img'] != null)
     echo '<img src="'.$row['img'].'" class="home-img" width="360" height="250" style="margin: 15 auto;">';
    echo'<div class="home-titulo h4">'.$row['titulo'].'</div>'.
    '<div class="home-sinopse h5">'.$row['sinopse'].'</div>'.
    '<div class="home-likes">By: '.$autor['nome'].' - 👍 '.$row['likes'].'</div>'.
    '</div>';
}
function showPost($conn, $row){
    $autor = mysqli_fetch_assoc(mysqli_query ( $conn, "select * from `usuarios` where id = '".$row['autor']."';" ));
    echo '<div class="home-post card m-auto text-center" style="width: 58rem;">';
    if($row['img'] != null)
         echo '<img src="'.$row['img'].'" class="home-img" style="max-width: 500; max-height: 590; margin: 15 auto;">';
    echo '<div class="home-titulo h1">'.$row['titulo'].'</div>'.
    '<div class="home-autor">Autor: '.$autor['nome'].'</div>'.
    '<div class="home-conteudo">'.$row['conteudo'].'</div>'.
    '<div class="home-likes">Curtidas: '.$row['likes'].'</div>'.
    '<div class="home-data">Data de postagem: '.$row['data'].'</div>';
    $result = mysqli_query ( $conn, "select * from `comentarios` where post = '".$row['id']."';" );
    if($result->num_rows > 0)
     echo '<div class="home-comentario h2">Comentarios:</div>' ;
     foreach(mysqli_fetch_all($result, MYSQLI_ASSOC) AS $row) {
        $autor = mysqli_fetch_assoc(mysqli_query ( $conn, "select * from `usuarios` where id = '".$row['autor']."';" ));
         echo '<div class="card home-comentario text-left">'.
                '<div class="home-comentario-autor">'.$autor['nome'].' - '.$row['data'].'</div>'.
                '<div class="home-comentario-conteudo">'.$row['conteudo'].'</div>';
         echo '</div>';
     }
    echo '</div>';
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <style>
            *{
                margin: 0;
                padding: 0;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="card" style="width:100%; height: 250px; background-color: black">
        </div>
        <?php
        if (isset($_GET ["post"])){
            $post_id = $_GET["post"];
            try{
                $post = mysqli_fetch_assoc(mysqli_query ( $conn, "select * from `posts` where id = '".$post_id."';" ));
                showPost($conn, $post);
            }catch(Exception $ex){/*ignore*/}
        }
        if (isset($_GET ["home"])){
            $result = mysqli_query ( $conn, 'select * from `posts` where id;' );
            if (mysqli_num_rows ($result) > 0) {
                echo '<div class="d-flex justify-content-center row column">';
                foreach(mysqli_fetch_all($result, MYSQLI_ASSOC) AS $row)
                    showPostHome($conn, $row);
                echo '</div>';
            }
        }
        ?>
        <script>
            function goPost(id){window.location.href = "http://localhost/blog/?post="+id;}
         </script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>

 