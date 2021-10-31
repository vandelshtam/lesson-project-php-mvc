<?php
namespace App\Controllers;
session_start();

use App\Models\Posts;
use App\lib\Pagination;
use App\Core\Controller;
use App\lib\Pagination_comments;
use App\Models\Validator;
use App\Models\flashMessage;
use App\Models\MediaBuilder;

class PostsController extends Controller{


    public function __construct($route) {
		parent::__construct($route);
		$this->view->layout = 'custom_posts';
	}




    public function postsAction(){
        if($_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа!');
            $this->view->redirect('/posts');
        }
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

            $vars = [
                'navigate'  => $navigate,
                'pagination' => $pagination->get(),
			    'posts' => $this->model->postsListAll($page),
                ];  
            $this->view->render('Posts list page', $vars);
    }




    public function favoritesPostsAction(){
        if($_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа!');
            $this->view->redirect('/posts');
        }
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
        $get_post = $this->model->getUser('posts','user_id',$_SESSION['user_id']);
        if($_SESSION['auth'] != true || $get_post != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа или вы еще не создали ни одного поста!');
            $this->view->redirect('/posts');
        }
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
        
        $get_post = $this->model->getUser('posts','id',$this->route['id']);
        if(empty($get_post)){
            flashMessage::addFlash('danger', ' Пост не найден');
            $this->view->redirect('/posts');
        }
        $data = ['users', 'infos', 'socials', 'posts']; 
        $post = $this->model->postOne($data,$this->route['id'], 'post_id','id', 'user_id', 'users.id','','');
        
        if($_SESSION['admin'] != 1){
            flashMessage::addFlash('danger', 'У вас нет прав доступа!');
            $this->view->redirect('/posts');
        }
        

        if(empty($_SESSION['page_id'])){
            $page = 1;
        }
        else{
            $page = $_SESSION['page_id'];
        }
        if(empty($_SESSION['route'])){
            $route_paginate = [
                "controller"=> "posts",
                "action"=> "pagination_comments",
                "page"=> 1];
        }
        else{
            $route_paginate = $_SESSION['route'];
        }
        
        $pagination_comments = new Pagination_comments($route_paginate, $this->model->postsCount('comments'));
        $navigate = [
            'myPosts' => 0,
            'favorites' => 0,
            'postsAll' => 0,
            'searchPosts' => 0];
            $data = ['users', 'infos', 'socials', 'posts']; 
            $vars = [
                'post' => $post,
                'navigate'  => $navigate,
                'comments' => $this->model->commentsListAll($page,'post_id',$this->route['id']),
                'pagination' => $pagination_comments->get(),
                'images' => $this->model->imagesPost('images',$this->route['id'], ':id','post_id','created_at',''),
                ]; 

            $this->model->set_session_post($post[0]); 
            unset($_SESSION['page_id']);
            unset($_SESSION['route']);    
            $this->view->render('Posts list page', $vars);
    }




    public function pagination_commentsAction(){
         
        $_SESSION['page_id'] = $this->route['page'];
        $_SESSION['route'] = $this->route;
        $this->view->redirect('/post/'.$_SESSION['post_id']);  
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
                    $dataImage = ['image' => $new_image, 'user_id' => $post['user_id'], 'post_id' => $post['id'], 'imageable_id' => 0];
                    $media = new MediaBuilder;
                    $media -> createImage('images',$dataImage);
                    $newImageId =  $this->model->newPostId();          
                    $data_imageable = [ 
                        'imageable_id' => $newImageId     
                    ];
                    $this->model->updateImage('images',$data_imageable,'id',$newImageId);   
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
        $newCommentId =  $this->model->newPostId();           
                    $data = [ 
                        'commentable_id' => $newCommentId     
                    ];
        $this->model->updateComment('comments',$data,'id',$newCommentId);               
        $this->view->redirect('/post/'.$this->route['id']);  
    }





    public function deleteCommentAction(){
        if($this->model->getPost('comments','user_id',$_SESSION['user_id']) != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/post/'.$_POST['post_id']); 
        }
        $this->model->deleteComment('comments','id',$this->route['id']);    
        $this->view->redirect('/post/'.$_POST['post_id']);  
    }




    public function bannedPostAction(){
        if($_SESSION['admin'] != 1){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/post/'.$this->route['id']);
        }
        $data = ['banned' => 1];
        $this -> model -> updatePost('posts',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно заблокировали пост');
        $this->view->redirect('/post/'.$this->route['id']);
    }




    public function unBannedPostAction(){
        if($_SESSION['admin'] != 1){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/post/'.$this->route['id']);
        }
        $data = ['banned' => 0];
        $this -> model -> updatePost('posts',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно раззаблокировали пост');
        $this->view->redirect('/post/'.$this->route['id']);
    }




    public function bannedCommentAction(){
        if($_SESSION['admin'] != 1){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/post/'.$this->route['id']);
        }
        $data = ['banned' => 1];
        $comment = $this -> model -> getComment('comments','id',$this->route['id']);
        $post = $comment['post_id'];
        $this -> model -> updateComment('comments',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно заблокировали комментарий');
        $this->view->redirect('/post/'.$post);
    }




    public function unBannedCommentAction(){
        if($_SESSION['admin'] != 1){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/post/'.$this->route['id']);
        }
        $data = ['banned' => 0];
        $comment = $this -> model -> getComment('comments','id',$this->route['id']);
        $post = $comment['post_id'];
        $this -> model -> updateComment('comments',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно раззаблокировали комментарий');
        $this->view->redirect('/post/'.$post);
    }




    public function addFavoritesAction(){
        if($_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа!');
            $this->view->redirect('/posts');
        }
        $data = ['favorites' => 1];
        $this -> model -> updatePost('posts',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно добавили пост в избранное');
        $this->view->redirect('/post/'.$this->route['id']);
    }




    public function deleteFavoritesAction(){
        if($_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа!');
            $this->view->redirect('/posts');
        }
        $data = ['favorites' => 0];
        $this -> model -> updatePost('posts',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно удалили пост из избранного');
        $this->view->redirect('/post/'.$this->route['id']);
    }





    public function imagePostShowAction(){
        $image = $this->model->getPost('images','id',$this->route['id']);
        if($image == false){
            flashMessage::addFlash('danger', 'Фотография не найдена!');
            $this->view->redirect('/post/'.$this->route['id']);
        }
        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $image['user_id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/post/'.$this->route['id']);
        }
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
        $image = $this->model->getPost('images','id',$this->route['id']);
        if($image == false){
            flashMessage::addFlash('danger', 'Ошибка удаления, вы не можете удалить картинку!');
            $this->view->redirect('/post/'.$this->route['id']);
        }
        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $image['user_id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/post/'.$this->route['id']);
        } 
        $image = $this->model->imagesPost('images',$this->route['id'],':id','id','created_at','');
        $this-> model -> deleteFileImage('images','id',$this->route['id']);
        $this -> model -> deleteImage('images',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно удалили фотографию');
        $this->view->redirect('/post/'.$image[0]['post_id']);
    }





    public function addPostAction(){
        if($_SESSION['admin'] != 1 || $_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/post');
        }
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
                            if($validate->validateImageAvatarPost() != null){
                                $errors = $validate->validateImageAvatarPost();
                                $this->view->render('Add new post', $vars, $errors); die;  
                            }
                            else{
                                $new_avatar=$this->model->makeNewAvatar('avatar_post');
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
                            }
                            else{
                                $new_image=$this->model->makeNewImage('image');
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
                        $newImageId =  $this->model->newPostId();          
                        $data_imageable = [ 
                        'imageable_id' => $newImageId     
                        ];
                    $this->model->updateImage('images',$data_imageable,'id',$newImageId);                              
                    } 

                    if(!empty($_FILES['image']['name'])){
                                        
                        $dataImage = ['image' => $new_image, 'user_id' => $this->route['id'], 'post_id' => $newPostId, 'imageable_id' => $newPostId];
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
