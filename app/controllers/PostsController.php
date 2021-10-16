<?php
namespace App\Controllers;
session_start();

use App\Models\Posts;
use App\Core\Controller;
use App\Models\Validator;
use App\Models\flashMessage;
use App\Models\MediaBuilder;

class PostsController extends Controller{


    public function __construct($route) {
		parent::__construct($route);
		$this->view->layout = 'custom_posts';
	}

    public function postsAction(){
        
        $navigate = [
            'myPosts' => 0,
            'favorites' => 0,
            'postsAll' => 1,
            'searchPosts' => 0];
            $data = ['users', 'infos', 'posts'];
            $vars = [
                'posts' => $this->model->postsAll($data),
                //'posts' => $this->model->postsAll1(),
                'navigate'  => $navigate
                ]; 
            //dd($vars);   
            $this->view->render('Posts list page', $vars);
    }

    public function favoritesPostsAction(){
        
        $navigate = [
            'myPosts' => 0,
            'favorites' => 1,
            'postsAll' => 0,
            'searchPosts' => 0];
            $data = ['users', 'infos', 'posts'];
            $vars = [
                'posts' => $this->model->postsAllWhere($data,'favorites', 1),
                //'posts' => $this->model->postsAll1(),
                'navigate'  => $navigate
                ]; 
            //dd($vars);   
            $this->view->render('Posts list favorites page', $vars);
    }

    public function myPostsAction(){
        
        $navigate = [
            'myPosts' => 1,
            'favorites' => 0,
            'postsAll' => 0,
            'searchPosts' => 0];
            $data = ['users', 'infos', 'posts'];
            $vars = [
                'posts' => $this->model->postsAllWhere($data,'user_id', $this->route['id']),
                'navigate'  => $navigate
                ]; 
            //dd($vars);   
            $this->view->render('Posts list favorites page', $vars);
    }




    public function postAction(){
        //dd($this->route['id']);
        $navigate = [
            'myPosts' => 0,
            'favorites' => 0,
            'postsAll' => 0,
            'searchPosts' => 0];
            $data = ['users', 'infos', 'socials', 'posts']; 
            $tables = ['users', 'infos', 'comments'];   
            $vars = [
                'post' => $this->model->postOne($data,$this->route['id'], 'post'),
                'navigate'  => $navigate,
                'comments' => $this->model->comments($tables,$this->route['id'],'post'),
                'images' => $this->model->imagesPost('images',$this->route['id'],'post_id','created_at',''),
                ]; 
            //dd($vars);  
            $this->view->render('Posts list page', $vars);
    }

    public function editPostAction(){
        //dd($this->route['id']);
        $errors =[];
       
            //dd($vars); 

        if(!empty($_FILES['avatar_post']['name'])){
            $validate = new Validator($_POST);
            if($validate->validateImageAvatarPost() != null){
                $errors = $validate->validateImageAvatarPost();
                //dd($errors);
                //$this->view->redirect('/editPost/'.$this->route['id']);
            }
            else{
                $media = new MediaBuilder;
                $new_avatar=$media->makeNewAvatarPost();
                if($media->loadingFileAvatarPost($new_avatar) == false){
                    flashMessage::addFlash('denger', 'Не удалось загрузить файл');
                    
                }
                else{
                    $dataAvatar = ['avatar_post' => $new_avatar];
                    $post = $this->model->getPost('posts','id',$this->route['id']);
                    $media->delete_file_post('posts','id',$this->route['id']);
                    $media->updateAvatar('posts',$dataAvatar,$this->route['id']); 
                    flashMessage::addFlash('success', 'Вы успешно загрузили новый аватар');
                    
                }
            }
        }

        if(!empty($_FILES['image']['name'])){
            $validate = new Validator($_POST);
            if($validate->validateImagePost() != null){
                $errors = $validate->validateImagePost();
                //dd($errors);
                //$this->view->redirect('/editPost/'.$this->route['id']);
            }
            else{
                $media = new MediaBuilder;
                $new_image=$media->makeNewImagePost();
                //dd($new_image);
                if($media->loadingFileImagePost($new_image) == false){
                    flashMessage::addFlash('denger', 'Не удалось загрузить файл');
                    
                }
                else{
                    
                    $post = $this->model->getPost('posts','id',$this->route['id']);
                    $dataImage = ['image' => $new_image, 'user_id' => $post['user_id'], 'post_id' => $post['id'], 'imageable_id' => $post['id'], 'imageable_type' => 'App\Model\Post'];
                    //$media->delete_file_post('posts','id',$this->route['id']);
                    $media -> createImage('images',$dataImage);
                    //$media->updateAvatar('posts',$dataAvatar,$this->route['id']); 
                    flashMessage::addFlash('success', 'Вы успешно загрузили новую картинку');
                    
                }
            }
        }

        if(!empty($_POST['name_post']) || !empty($_POST['title_post']) || !empty($_POST['text'])){
            $validate = new Validator($_POST);
            if($validate->validateEditPost() != null){
                $errors = $validate->validateEditPost();
               // dd($_POST);
                //$this->view->redirect('/editPost/'.$this->route['id']);
            }
            else{
                
                $post = $this->model->getPost('posts','id',$this->route['id']);
                $dataPost = ['name_post' => $_POST['name_post'], 'title_post' => $_POST['title_post'], 'text' => $_POST['text']];
                //$media->delete_file_post('posts','id',$this->route['id']);
               // $media -> createImage('images',$dataImage);
                $this -> model -> updatePost('posts',$dataPost,'id',$this->route['id']); 
                flashMessage::addFlash('success', 'Вы успешно  обновили информацию поста');
                $this->view->redirect('/post/'.$this->route['id']);   
                
            }
        }

         $navigate = [
            'myPosts' => 0,
            'favorites' => 0,
            'postsAll' => 0,
            'searchPosts' => 0];
           
            $vars = [
                'post' => $this->model->getPost('posts','id',$this->route['id']),
                'navigate'  => $navigate,
                'images' => $this->model->imagesPost('images',$this->route['id'],'post_id','created_at',''),
                ];         
            $this->view->render('Edit post', $vars,$errors);
    }

    public function addNewCommentAction(){
        $this->route['id'];
        $data = [ 
            'user_id' => $_SESSION['user_id'],
            'comment' => $_POST['comment'],
            'post_id' => $this->route['id']      
        ];
        $this->model->createComment('comments',$data);    
        //dd($vars); 
        $this->view->redirect('/post/'.$this->route['id']);  
    }

    public function deleteCommentAction(){
        //dd($this->route['id']);
        $this->model->deleteComment('comments',$this->route['id']);    
        //dd($vars); 
        $this->view->redirect('/post/'.$_POST['post_id']);  
    }

    public function changeAvatarAction(){
        //if(!empty($_FILES)){
            $validate = new Validator($_POST);
            if($validate->validateImageAvatar() != null){
                $errors = $validate->validateImageAvatar();
                //dd($errors);
                $this->view->redirect('/editPost/'.$this->route['id']);
            }
            else{
                $media = new MediaBuilder;
                $new_avatar=$media->makeNewAvatar();
                if($media->loadingFileAvatar() == false){
                    flashMessage::addFlash('denger', 'Не удалось загрузить файл');
                    $this->view->redirect('/post/'.$_POST['post_id']);
                }
                else{
                    $dataAvatar = ['avatar' => $new_avatar];
                    $post = $this->model->getPost('posts','id',$this->route['id']);
                    $media->delete_file('posts','id',$this->route['id']);
                    $media->updateAvatar('posts',$dataAvatar,$post['avatar_post']); 
                    flashMessage::addFlash('success', 'Вы успешно загрузили новый аватар');
                    $this->view->redirect('/post/'.$_POST['post_id']);
                }
            }
        //}
    }

    public function bannedPostAction(){
        $data = ['banned' => 1];
        $this -> model -> updatePost('posts',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно заблокировали пост');
        $this->view->redirect('/post/'.$this->route['id']);
    }

    public function unBannedPostAction(){
        $data = ['banned' => 0];
        $this -> model -> updatePost('posts',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно раззаблокировали пост');
        $this->view->redirect('/post/'.$this->route['id']);
    }

    public function addFavoritesAction(){
        $data = ['favorites' => 1];
        $this -> model -> updatePost('posts',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно добавили пост в избранное');
        $this->view->redirect('/post/'.$this->route['id']);
    }

    public function deleteFavoritesAction(){
        $data = ['favorites' => 0];
        $this -> model -> updatePost('posts',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно удалили пост из избранного');
        $this->view->redirect('/post/'.$this->route['id']);
    }

    public function imagePostShowAction(){
        $errors = [];
        $navigate = [
            'myPosts' => 0,
            'favorites' => 0,
            'postsAll' => 0,
            'searchPosts' => 0];
            $image = $this->model->imagesPost('images',$this->route['id'],'id','created_at','');
            
            $vars = [
                
                'navigate'  => $navigate,
                'image' => $image,
                'post' => $this->model->getPost('posts','id',$image[0]['post_id'])
                ]; 
                //dd($vars);       
            $this->view->render('Image post show', $vars,$errors);
    }

    public function delete_imageAction(){
       
        $media = new MediaBuilder;
        $image = $this->model->imagesPost('images',$this->route['id'],'id','created_at','');
        $media->delete_image_post('images','id','image',$this->route['id']);
        $this -> model -> deleteImage('images',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно удалили фотографию');
        $this->view->redirect('/post/'.$image[0]['post_id']);
    }
}