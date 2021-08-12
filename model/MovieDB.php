<?php

namespace MagentoModule
{
    class MovieDB extends Main
    {

        public function __construct()
        {
            parent::__construct();
        }


        public function GetMovie($id = 0)
        {
            $aux = array(
                'id'=>0,
                'titulo'=>'',
                'foto'=>''
            );
            if($id>0)
            {
                $aux = $this->ListMovies(array('where'=>'m.id = '.$id));
                $aux = $aux['list'][0];
            }
            return $aux;
        }

        public function ListMovies($options = array())
        {
            $settings = array_merge(array(
                'where'=>'',
                'order'=>'',
                'pagina'=>1,
                'limite'=>20
            ),$options);

            $aux = array(
                'list'=>array(),
                'total'=>0
            );
            $sql = "
            SELECT Count(m.id) total
            FROM movies m
            LEFT JOIN movies_favs mf ON m.id = mf.movie AND usuario = ".$_SESSION['uid'];
            if($settings['where']!='') $sql.=' WHERE '.$settings['where'];

            $res = parent::Query($sql);
            $aux['total'] = intval($res[0]['total']);

            $sql = "
            SELECT
                m.id,
                m.titulo,
                m.foto,
                (CASE WHEN mf.id IS NULL THEN 0 ELSE 1 END) favorito
            FROM movies m
            LEFT JOIN movies_favs mf ON m.id = mf.movie AND usuario = ".$_SESSION['uid'];
            if($settings['where']!='') $sql.=' WHERE '.$settings['where'];
            $res = parent::Query($sql);
            $aux['list'] = $res;
            return $aux;
        }
        public function ListIMDB($get)
        {
            $res = parent::Curl(TMDB_URL.'/3/search/movie?api_key='.TMDB_V3AUTH.'&'.http_build_query(array('query'=>$get['q'])));
            return array('status'=>200,'dados'=>json_decode($res,true));
        }
        public function SaveIMDB($post)
        {
            $res = $this->ListMovies(array('where'=>'m.id = '.$post['tmdb']));
            if($res['total']>0)
            {
                $sql = "
                UPDATE movies
                SET titulo = :titulo,
                    foto = :foto
                WHERE id = :id";
            }
            else
            {
                $sql = "
                INSERT INTO movies
                (
                    id,
                    titulo,
                    foto
                )
                VALUES
                (
                    :id,
                    :titulo,
                    :foto
                )";
            }
            parent::Query($sql,array(
                ':id'=>$post['tmdb'],
                ':titulo'=>$post['titulo'],
                ':foto'=>$post['foto']
            ));
            return array('status'=>200,'mensagem'=>'ok');
        }
        public function RemoverMovie($id)
        {
            $sql = "
            DELETE FROM movies
            WHERE id = :id";
            parent::Query($sql,array(
                ':id'=>$id
            ));
            return array('status'=>200,'mensagem'=>'ok');
        }
        public function Favoritar($post)
        {
            if($post['action']=="true")
            {
                $sql = "
                SELECT id
                FROM movies_favs
                WHERE movie = :movie AND usuario = :usuario";
                $res =  parent::Query($sql,array(
                    ':movie'=>$post['id'],
                    ':usuario'=>$_SESSION['uid']
                ));
                if(count($res)==0)
                {
                    $sql = "
                    INSERT INTO movies_favs
                    (movie, usuario)
                    VALUES
                    (:movie,:usuario)";
                    parent::Query($sql,array(
                        ':movie'=>$post['id'],
                        ':usuario'=>$_SESSION['uid']
                    ));
                }
            }
            else
            {
                $sql = "
                DELETE FROM movies_favs
                WHERE movie = :movie AND usuario = :usuario";
                parent::Query($sql,array(
                    ':movie'=>$post['id'],
                    ':usuario'=>$_SESSION['uid']
                ));
            }
            return array('status'=>200,'mensagem'=>'ok');
        }
    }
}

?>