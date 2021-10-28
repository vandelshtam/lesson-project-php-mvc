<?php
namespace App\Controllers;
session_start();

use App\Models\Posts;
use App\lib\Pagination;
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
        if(empty($this->route['page'])){
            $page = 1;
        }
        else{
            $page = $this->route['page'];
        }
        $pagination = new Pagination($this->route, $this->model->postsCount('posts'));
        $navigate = [
            'myPosts' => 0,
            'favorites' => 0,
            'postsAll' => 1,
            'searchPosts' => 0];
            //$data = ['users', 'infos', 'posts'];

            $vars = [
                //'posts' => $this->model->postsAll($data,'user_id', 'users.id'),
                'navigate'  => $navigate,
                'pagination' => $pagination->get(),
			    'posts' => $this->model->postsListAll($page),
                ];  
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
                'posts' => $this->model->postsAllFavorites($data, 1, 'favorites', 'value', 'user_id', 'users.id','',''),
                'navigate'  => $navigate
                ];  
            $this->view->render('Posts favorites page', $vars);
    }

    public function myPostsAction(){
        $navigate = [
            'myPosts' => 1,
            'favorites' => 0,
            'postsAll' => 0,
            'searchPosts' => 0];
            $data = ['users', 'infos', 'posts'];
            $vars = [
                'posts' => $this->model->postsAllMy($data, $this->route['id'], 'user_id', 'route_id', 'user_id', 'users.id','',''),
                'navigate'  => $navigate
                ];    
            $this->view->render('My Posts list', $vars);
    }


    public function postAction(){
        $navigate = [
            'myPosts' => 0,
            'favorites' => 0,
            'postsAll' => 0,
            'searchPosts' => 0];
            $data = ['users', 'infos', 'socials', 'posts']; 
            $tables = ['users', 'infos', 'comments'];   
            $vars = [
                'post' => $this->model->postOne($data,$this->route['id'], 'post_id','id', 'user_id', 'users.id','',''),
                'navigate'  => $navigate,
                'comments' => $this->model->commentsAll($tables, $this->route['id'], 'post_id', 'post_id', 'user_id', 'users.id','',''),
                'images' => $this->model->imagesPost('images',$this->route['id'], ':id','post_id','created_at',''),
                ]; 
            $this->view->render('Posts list page', $vars);
    }


    public function editPostAction(){
        $post = $this->model->getPost('posts','id',$this->route['id']);
        if($post == false){
            flashMessage::addFlash('danger', 'Такого поста нет!');
            $this->view->redirect('/posts');
        }
        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $post['user_id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/post/'.$this->route['id']);
        }
        $errors =[];
        if(!empty($_FILES['avatar_post']['name'])){
            $validate = new Validator($_POST);
            if($validate->validateImageAvatarPost() != null){
                $errors = $validate->validateImageAvatarPost();
            }
            else{
                $new_avatar=$this->model->makeNewAvatar('avatar_post');
                if($this->model->loadingFileAvatar($new_avatar) == false){
                    flashMessage::addFlash('denger', 'Не удалось загрузить файл');   
                }
                else{
                    $dataAvatar = ['avatar_post' => $new_avatar];
                    $this->model->deleteFileAvatar('posts','id',$this->route['id']);
                    $media = new MediaBuilder;
                    $media->updateAvatar('posts',$dataAvatar,'id',$this->route['id']); 
                    flashMessage::addFlash('success', 'Вы успешно загрузили новый аватар');
                    
                }
            }
        }

        if(!empty($_FILES['image']['name'])){
            $validate = new Validator($_POST);
            if($validate->validateImagePost() != null){
                $errors = $validate->validateImagePost();
            }
            else{
                $new_image=$this->model->makeNewImage('image');
                if($this->model->loadingFileImage($new_image) == false){
                    flashMessage::addFlash('denger', 'Не удалось загрузить файл');    
                }
                else{
                   // $post = $this->model->getPost('posts','id',$this->route['id']);
                    $dataImage = ['image' => $new_image, 'user_id' => $post['user_id'], 'post_id' => $post['id'], 'imageable_id' => $post['id'], 'imageable_type' => 'App\Model\Post'];
                    $media = new MediaBuilder;
                    $media -> createImage('images',$dataImage);
                    flashMessage::addFlash('success', 'Вы успешно загрузили новую картинку');    
                }
            }
        }

        if(!empty($_POST['name_post']) || !empty($_POST['title_post']) || !empty($_POST['text'])){
            $validate = new Validator($_POST);
            if($validate->validateEditPost() != null){
                $errors = $validate->validateEditPost();
            }
            else{   
                $post = $this->model->getPost('posts','id',$this->route['id']);
                $dataPost = ['name_post' => $_POST['name_post'], 'title_post' => $_POST['title_post'], 'text' => $_POST['text']];
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
            'images' => $this->model->imagesPost('images',$this->route['id'], ':id','post_id','created_at',''),
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
        $this->view->redirect('/post/'.$this->route['id']);  
    }


    public function deleteCommentAction(){
        $this->model->deleteComment('comments','id',$this->route['id']);    
        $this->view->redirect('/post/'.$_POST['post_id']);  
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

    public function bannedCommentAction(){
        $data = ['banned' => 1];
        $comment = $this -> model -> getComment('comments','id',$this->route['id']);
        $post = $comment['post_id'];
        $this -> model -> updateComment('comments',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно заблокировали комментарий');
        $this->view->redirect('/post/'.$post);
    }

    public function unBannedCommentAction(){
        $data = ['banned' => 0];
        $comment = $this -> model -> getComment('comments','id',$this->route['id']);
        $post = $comment['post_id'];
        $this -> model -> updateComment('comments',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно раззаблокировали комментарий');
        $this->view->redirect('/post/'.$post);
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
            $image = $this->model->imagesPost('images',$this->route['id'],':id','id','created_at','');   
        $vars = [   
            'navigate'  => $navigate,
            'image' => $image,
            'post' => $this->model->getPost('posts','id',$image[0]['post_id'])
            ];   
        $this->view->render('Image post show', $vars,$errors);
    }

    public function delete_imageAction(){  
        $image = $this->model->imagesPost('images',$this->route['id'],':id','id','created_at','');
        $this-> model -> deleteFileImage('images','id',$this->route['id']);
        $this -> model -> deleteImage('images',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно удалили фотографию');
        $this->view->redirect('/post/'.$image[0]['post_id']);
    }


    public function addPostAction(){
        $errors = [];
        $navigate = [
            'myPosts' => 0,
            'favorites' => 0,
            'postsAll' => 0,
            'searchPosts' => 0];    
        $vars = [
            'navigate'  => $navigate,
            ]; 
        $validation = new Validator($_POST);

        if($_SESSION['admin'] != 1 && $_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/posts');
        } 

        
        if(empty($_POST['name_post']) || empty($_POST['title_post']) || empty($_POST['text'])){
            flashMessage::addFlash('info', 'Нужно обязательно заполнить 3 поля: "name_post", "title_post", "text"');    
        }
        else{
            
            if($validation->validateEditPost() != null){
                $errors = $validation->validateEditPost();
            }
            else{
                
                $post = $this->model->getPost('posts','name_post',$_POST['name_post']);

                if(!empty($post))
                {
                    flashMessage::addFlash('info', 'Не возможно добавить пост с таким названием, это название занято');    
                }
                else{
                    $user = $this->model->getUser('users','id',$this->route['id']);
                    $dataPost = [ 
                            'name_post' => $_POST['name_post'],
                            'title_post' => $_POST['title_post'],
                            'text' => $_POST['text'],
                            'user_id' => $this -> route['id'],
                            'banned' => 0, 
                            'info_id' => $user['info_id'],
                            'social_id' => $user['social_id'],
                            'postable_id' => 0,
                            'c' => 0,
                            'search_post' => strtolower($_POST['name_post']),   
                        ];

                        if(!empty($_FILES['avatar_post']['name'])){
                            $validate = new Validator($_POST);
                            //dd($_FILES['avatar_post']['name']);
                            if($validate->validateImageAvatarPost() != null){
                                $errors = $validate->validateImageAvatarPost();
                                $this->view->render('Add new post', $vars, $errors); die;  
                            }
                            else{
                                $new_avatar=$this->model->makeNewAvatar('avatar_post');
                                //dd($new_avatar);
                                if($this->model->loadingFileAvatar($new_avatar) == false){
                                    flashMessage::addFlash('denger', 'Не удалось загрузить файл'); 
                                    $this->view->render('Add new post', $vars, $errors); die;     
                                }
                            }
                        }
                        if(!empty($_FILES['image']['name'])){
                            $validate = new Validator($_POST);
                            if($validate->validateImagePost() != null){
                                $errors = $validate->validateImagePost();
                                $this->view->render('Add new post', $vars, $errors); die;  
                                //dd($errors);
                            }
                            else{
                                $new_image=$this->model->makeNewImage('image');
                                //dd($new_image);
                                if($this->model->loadingFileImage($new_image) == false){
                                    flashMessage::addFlash('denger', 'Не удалось загрузить файл'); 
                                    $this->view->render('Add new post', $vars, $errors); die;    
                                }
                            }
                        }
                    
                    $this->model->createPost('posts', $dataPost);
                    $newPostId =  $this->model->newPostId();
                    $c = 'c_'.$newPostId;
                    $data = [ 
                        'post_id' => $newPostId,
                        'postable_id' => $newPostId,
                        'c' => $c,   
                    ];
                    $this->model->updatePost('posts',$data,'id',$newPostId);

                    if(!empty($_FILES['avatar_post']['name'])){
                                            
                        $media = new MediaBuilder;
                        $dataAvatar = ['avatar_post' => $new_avatar];
                        $media->updateAvatar('posts',$dataAvatar,'id',$newPostId);                            
                    } 

                    if(!empty($_FILES['image']['name'])){
                                        
                        $dataImage = ['image' => $new_image, 'user_id' => $this->route['id'], 'post_id' => $newPostId, 'imageable_id' => $newPostId, 'imageable_type' => 'App\Model\Post'];
                        $media = new MediaBuilder;
                        $media -> createImage('images',$dataImage);    
                    }

                    flashMessage::addFlash('success', 'Вы успешно добавили новый пост'); 
                    $this->view->redirect('/post/'.$newPostId);   

                }   
            }       
        }
        $this->view->render('Add new post', $vars, $errors);   
    }



    public function deletePostAction(){
        $post = $this->model->getPost('posts','id',$this->route['id']);
        if($post == false){
            flashMessage::addFlash('info', 'Такого поста нет!');
            $this->view->redirect('/post/'.$this->route['id']);
        }

        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $post['user_id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/post/'.$this->route['id']);
        }                                   
        $this -> model -> deleteAllImagesInPost('images',$this->route['id'], ':id','post_id','created_at','');
        $this -> model -> deleteFileAvatar('posts','id',$this->route['id']); 
        

        $this->model->deleteTablePost('posts','id', $this->route['id']);
        $this->model->deleteTablePost('images','post_id',$this->route['id']);
        $this->model->deleteTablePost('comments','post_id',$this->route['id']);
        flashMessage::addFlash('success', 'Вы успешно удалили пост!');
        $this->view->redirect('/posts');
    }

    
}
