<?php
namespace src\controllers;
//namespace src\models;

use \core\Controller;
use \src\models\User;

class HomeController extends Controller {

    public function index(){
        $this->render('home');
    }

   public function lista(){
       $dados = '';
       $parpag = 2;
       $page = (!empty($_GET['page']))?intval($_GET['page']):0;
       $pes = (!empty($_GET['pesquisa']))?$_GET['pesquisa']:'';
       if(!empty($pes)){
            $dados = User::select()
                ->orWhere('id','like' ,'%'.$pes.'%')
                ->orWhere('nome','like' ,'%'.$pes.'%')
                ->page($page,$parpag)
            ->get();
            $total = User::select()
                ->orWhere('id','like' ,'%'.$pes.'%')
                ->orWhere('nome','like' ,'%'.$pes.'%')
                ->page($page,$parpag)
            ->count();
       }else{
            $dados = User::select()->page($page,$parpag)->get();
            $total = User::select()->page($page,$parpag)->count();
       }

      
       $pageCount = ceil($total/$parpag);

       echo json_encode(['dados'=>$dados,'pageCount'=>$pageCount]);
   }

   public function getdev($agrs = []){
       $dados = User::select()->where('id', $agrs['id'])->one();
       echo json_encode($dados);
    }

    public function add(){
        if(!empty($_POST)){ 
            User::insert([
                'nome'=> $_POST['nome'],
                'sexo'=> $_POST['sexo'],
                'idade'=> $_POST['idade'],
                'hobby'=> $_POST['hobby'],
                'data_nascimento'=> $_POST['data_nascimento']
            ])->execute();
                
        }
        echo json_encode(true);
                
    }

    public function edit($agrs = []){           
        if(!empty($_POST)){ 
            User::update([
                'nome'=> $_POST['nome'],
                'sexo'=> $_POST['sexo'],
                'idade'=> $_POST['idade'],
                'hobby'=> $_POST['hobby'],
                'data_nascimento'=> $_POST['data_nascimento']
            ])->where('id', $_POST['id'])->execute();
            echo json_encode(true);
        }
    }

    public function delete($agrs = []){
        if(!empty($agrs)){ 
            User:: delete()->where('id', $agrs['id'])->execute();
            echo json_encode(true);
        }
    }

    
}