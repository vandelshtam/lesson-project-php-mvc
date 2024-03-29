# lesson-project-php-oop-mvc (framework)
## 1. О проекте
### Название проекта "Book of friends"
Примечания:
- название не совпадает с названием папки проекта;
- фреймворк на чистом php  без компонентов
В этом проекте реализован простой web-сайт  социального сообщества. Сайт имеет три основных раздела:

- Раздел "Пользователи".
- Раздел "Посты"(статьи).
- Раздел "Чаты.

## 2. Краткое описание функциональных возможностей сайта

### Раздел "Пользователи" - главная страница
В разделе пользователи выполняется функционал по регистрации и редактирования данных пользователей, выводится информация о всех пользователях. Показываются профили пользователей.
В этом разделе авторизованные пользователи имеют возможность:
- регистрироваться.
- редактировать свои данные(аватар,контактные данные,информацию о себе).
- удалить свой профиль.
- редактировать свои данные безопасности(имя,email- он же "логин",пароль).
- просматривать свой профиль и профили зарегистрированных пользователей.
- изменять свой статус присутствия(онлайн, недоступен, отошел).

 Пользователь с правом "admin" имеет все выше перечисленные возможности, но по отношению к любому пользователю, в том числе создавать профили новых пользователей.
 Пользователь с правом (ролью) 'admin',  имеет возможность наделять/отзывать у других пользователей роль 'admin'. 
 Пользователь с ролью 'superadmin' имеет привилегии  как у  'admin', но установлена защита изменения этой роли самим пользователем или другими пользователями, роль назначается програмно.

Не авторизованные пользователи могут посещать только:
- главную страницу раздел "Пользователи".
- страницу регистрации.
- страницу авторизации.
На главной странице, не авторизованным пользователям доступен просмотр списка пользователей с ограниченной информацией о них.
 
### Раздел "Посты"

В этом разделе, зарегистрированные и авторизованные пользователи могут:
- просматривать свои посты и посты других пользователей, оставлять к ним комментарии.
- просматривать комментарии своих и других постов.
- удалять свои комментарии.
- создавать новые посты, редактировать свои посты.

Авторы поста или пользователь "admin"  имеют возможность управлять следующими данными:
- аватаром поста.
- фотографиями в галерее поста.
- заголовком поста.
- текстом поста.
- комментариями к посту.

"admin" дополнительно имеет возможность в любом посте:
- блокировать/разблокировать/удалять посты.
- блокировать/разблокировать/удалять комментарии.

### Раздел "Чаты"

В этом разделе, зарегистрированные и авторизованные пользователи могут:
- просматривать список чатов, участником которых является пользователь.
- открывать чаты участником которых является пользователь, отправлять и получать сообщения в чате.
- управлять чатами, автором которых является пользователь(менять участников, изменять роли участников, управлять аватаром, управлять названием).
- по умолчанию, автор чата имеет роль 'author' со всеми выше перечисленными возможностями, другие участники по умолчанию имеют роль 'participant', автор чата может предоставлять и отменять участникам роль 'moderator'. 'Moderator' получает все возможностями автора чата.
- автор 'author' чата может изменить автора, назначить вместа себя другого пользователя, сам при этом 
автоматически получает роль 'moderator'.
- пользователи могут покинуть чат по своему усмотрению, автор не может выйти из чата, не назначив другого автора 'author'.

Пользователь "admin"  наделен правом  управлять любыми чатами и сообщениями в чате:
- создавать/удалять/редактировать чаты.
- блокировать/разблокировать чаты.
- создавать/удалять сообщения в любом чате.


## 3. Краткая документация к проекту

### Проект реализован на языке PHP в стиле 'mvc'

#### Важные файлы проекта

#### Таблицы в БД 
В проекте созданы  таблицы:
- Users в которой содержиться регистрационная информация о пользователе(name, email, password).
- Infos хранит дополнительную информацию о пользователе(avatar,phone, location и др).
- Socials содержит информацию и социальных сетях пользователя(vk, telegram, instagram).
- Posts  содержит информацию о постах проекта.
- Comments хранение информации о комментариях к постам в проекте.
- Images хранение картинок к постам.
- Chats запись данных о чатах.
- Messages запись данных о  сообщениях в чатах.
- Userlists хранение данных связывающих пользователей уаствующих в чате, с другими таблицами.

#### Дерриктория App
##### Дерриктория App/config
routers.php - файл роутер запросов, определяется адресный Контролллер и Экшен в контроллере.

##### Дерриктория App/acl
В этой папке  файлы конфигурации устанавливающие правило допуска пользователя к контроллерам и экшенам, в зависимости от роли пользователя. Название файла соответсвует названию Контроллера, в файле устанавливается правило по котолрому пользователи допускаются/не допускаются к Экшену в зависимости от их роли.

##### Дерриктория App/Controllers
В папке содержатся файлы Контроллеров.Все действия связанные с  пользователями и их ресурсами производятся в данной дерриктории.

##### 'AuthControllers.php' этот файл (класс) выполняет:
- регистрацию пользователей.
- авторизацию пользователей.
- смену информации безопасности пользователей(смена почты, смена пароля, смена имени).
- выход из системы.
- повторное подтверждение пароля при выполнении важных действий.
-удаление пользователя.

##### 'UsersControllers.php' в этом классе выполняются следующие действия:
- вывод страниц со списком пользователей, вывод страницы профиля пользователей и их поиск.
- вывод страницы  и добавление нового пользователя.
- вывод страницы и выполнение изменения статуса присутсвия пользователя на сайте.
- вывод страницы и редактирование информации о пользователе.
- вывод страницы и изменение роли пользователя(предоставление роли администратора).
- вывод страницы и изменение аватара пользователя.
- вывод страницы (но не выполнение) удаления пользователя.
- блокировка/разблокировка пользователей

##### 'PostsControllers.php' в этом классе выполняются следующие действия:
- вывод страниц со списком  постов.
- вывод страницы  поста.
- добавление нового поста.
- редактирование поста.
- удаление поста.
- поиск постов.
- добавление/удаление постов в избранное/из избранного.
- блокировка/разблокировка постов.
- добавление/удаление комментариев к посту.
- блокировка/разблокировка коментариев к постам.
- вывод избранных постов.
- вывод моих (принадлежащих автору) постов.

##### 'ChatsControllers.php' в этом классе выполняются следующие действия:
- вывод страницы  списка чатов.
- вывод страницы открытого чата.
- добавление нового чата.
- редактирование чата.
- удаление чата.
- поиск чатов.
- изменение ролей учвастников чата.
- добавление/удаление чатов в избранное/из избранного.
- блокировка/разблокировка чатов.
- добавление/удаление сообщений в чате.
- вывод избранных чатов.
- вывод моих, принадлежащих автору, чатов.


##### Дерриктория App/Core
- Controller.php - файл с классом обрабатывающий конфигурацию допуска  пользователя в зависимости от их роли, создает объекты видов (view) и подключет методы создания/обработки видов, подключет соответсвующие контроллеру модели и методы, обрабатывает конфигурацию допуска пользователя в зависимости от его роли (из App/acl).
- Model.php - вызывает метод создания PDO.
- Router.php - обрабатывает конфигурации запросов пользователя, строит маршрут и параметры направления к соответсвующему файлу и его методу.
- View.php - класс построения шаблонов видов (view).

##### Дерриктория App/lib
Дополнительные сервисные файлы с классами, например Пагинации.

##### Дерриктория App/models
Файлы с классами моделей. Название файла и класса соответсвуют названию Колнтроллера если строят модели для конкретного контроллера, 
или название соответсвует выполняемому действию моделей.


##### Дерриктория public/css, public/js , public/img, public/media, public/uploads, public/webfonts
В данной папке лежат файлы стилей, медиафайлов и других компонентов верстки проекта.

##### Дерриктория database 
- config.php - кофигурация подключения к БД.
- Connection.php - создание шаблона подключения к БД.
- MakePdo.php - создание объекта запросов в БД.
- QueryBuilder.php - класс с методами построения запросов в БД.

##### Дерриктория resources 
Файлы верстки проекта:
Виды подключаемые к шаблонам видов. Название папки (например 'users') должно быть точно 
таким же как название метода в классе 'UsersController.php', это связано с логикой 
работы фреймворка, если методом (экшеном) предусмотрено подключения вида, то оно 
осуществляется по адресу из папки 'views'/ далее папка с названием контроллера 
например 'users'/далее файл вида имеющего точно такое же название как метод (экшен) 
контроллера например 'user_profile.php'.

###### /views/auth/
- 'page_login.php' страница авторизации пользовтеля.
- 'page_register.php' страница регистрации нового пользователя.
- 'confirm_password.php' страница повторного подтверждения пароля при выполнении важных изменений(смена почты, пароля, имя, удаления профиля пользователя).
- 'confirm_password_delete_post.php' страница повторного подтверждения пароля при выполнении удаления поста.

###### /views/chats/
- 'chats.php' страница вывода всех чатов.
- 'openChat.php' страница просмотра чата.
- 'myChat.php' страница просмотра моих (созданных авторизованным пользователем) чата.
- 'favoritesChat.php' страница просмотра избранных чата.
- 'addChatShow.php' страница добавления нового чата.
- 'editChatShow.php' страница редактирования чата.
- 'myChat.php' страница изменения ролей участников чата.

###### /views/errors/
-файлы ощибок.

###### /views/posts/
- 'posts.php' страница вывода всех постов.
- 'favoritesPosts.php' страница вывода всех избранных постов.
- 'myPosts.php' страница вывода всех собственных постов.
- 'post.php' страница просмотра поста.
- 'addPost.php' страница добавления нового поста.
- 'editPost.php' страница редактирования поста.
- 'imagePostShow.php' страница просмотра фотографий из галереи поста, просмотр реализован по одной фотографии.

###### /views/users/
- 'users.php' страница просмотра всех пользователей.
- 'user_profile.php' страница профиля пользоватиеля.
- 'create_users.php' страница создания нового пользователя.
- 'edit.php' страница редактирования информации о пользователе.
- 'change_email.php' страница изменения email  пользователя.
- 'security.php' страница изменения  данных безопасности пользователя (email, name, password).
- 'media.php' страница управления аватаром пользователя.
- 'statusShow.php' страница управления статусом пользователя.

- Основные шаблоны видов:

По умолчанию в проекте подключен вид 'default.php'  в классе  Controller.php   строка 23 -  $this->view->layout = 'default';
Можно назначить другой шаблон вида, для этого нужно создать файл вида, подключите его в конструкторе соответствующего контроллера,
для это используйте название файла без расширения ('.php'), например подключение шаблона к контроллеру  
AuthController.php строка 18 - $this->view->layout = 'custom_auth';

###### /views/layouts/
- custom_auth.php - шаблон вида для подключения файлов создания страниц подключаемых контроллером Auth.
- custom_chats.php  - шаблон вида для файлов создания страниц подключаемых контроллером Chats.
- custom_openChat.php - шаблон вида для подключения файлов  страниц подключаемых контроллером Chats но для показа страниц откытия чата.
- custom_posts.php  - шаблон вида для файлов создания страниц подключаемых контроллером Chats.
- default.php - шаблон по умолчанию, используется для главной страницы и всех страниц раздела "Пользователи".



## 4. Краткое описание логики работы проекта


### В файле App/config/routers.php

Устанавливаются правила маршрутизации запросов. В файле создан массив с вложенными ассоциативными массивами.
В ключе  к внутреннему ассоциотивному массиву записывается строка которая будет допущена к дальнейшей обработке 
- (в примере '/user/{id:\d+}');
 Во внутреннем ассоциативном массиве, в ключах записывается  параметр (в примере 'controller'), в значении название контролеера
(в примере 'users' название контроллера и название папки где будет находится файл шаблона вида должны быть одинаковыми! ), 
далее в ключе параметр (метода) экшен 'action' а в занчении название метода (экшена) напрмер 'user_profil' название должно быть одноименным
с методом в классе файла контролера, и названием подключемого вида (с расширением в названии файла) /resourses/views/users/user_profile.php.

пример построения параметров маршрута:

    '/user/{id:\d+}' => 

        [

            'controller' => 'users' (название должно совпадать с названием класса обработчика),
            'action' => 'user_profile' (название должно совпадать с названием метода в классе обработчике), 

        ]




#### Далее, по приведенному примеру роутера,  в файле App/Core/Router.php выполняется создание объекта в котором определяются адреса файлов контроллеров, видов, и т д, методов обработки и т п :

    object(App\Controllers\UsersController)#3 (4) 

    {

        //параметр обращения к контроллеру и методу обработки
    
        ['route'] => 

        array(3) {

            ["controller"]=>
            string(5) "users", //класс

            ["action"]=>
            string(12) "user_profile", //метод

            ["id"]=>
            int(1),

        }
    

  



  #### Параметр адреса шаблона вида и файла подключения страницы вида

    ["view"] =>   

        object(App\Core\View)#4 (3) 
        
        {

            ["pach"]=>
            string(18) "users/user_profile" //класс / метод класса
            ["layout"]=>
            string(7) "default" //важно! название шаблона вида в параметре должно совпадать с названием файла видла без учета расширения default.php
            ["route"]=>
            array(3) {
            ["controller"]=>
            string(5) "users" //важно! название контролера в параметре должно совпадать с названием класса 'UsersController' и названием файла класса без учета расширения 'UsersController.php'
            ["action"]=>
            string(12) "user_profile" //важно! название контролера в параметре должно совпадать с названием метода 'user_profile' и названием файла подключения страницы виды к шаблону вида  без учета расширения 'user_profile.php'
            ["id"]=>
            int(1)
            }
        }






  #### Параметр проверки правила доступа пользователя к контроллерам и методам, в данном случае разрешен доступ к методу 'users'  в контроллере UsersController.php

    ["acl"]=>

    array(4)

    {

        ["all"]=>

        array(1) 
        {
        [0]=>
        string(5) "users"
        }

    //важно! название доступного класса должно совпадать с названием метода в классе





#### параметр доступных методов (в контролеере 'UsersController.php') для авторизованного пользователя (роль 'authoris')
    ["authoris"]=>
    array(14) {
      [0]=>
      string(5) "users"
      [1]=>
      string(12) "user_profile"
      [2]=>
      string(4) "edit"
      [3]=>
      string(5) "media"
      [4]=>
      string(10) "statusShow"
      [5]=>
      string(9) "statusSet"
      [6]=>
      string(8) "mediaSet"
      [7]=>
      string(8) "security"
      [8]=>
      string(12) "change_email"
      [9]=>
      string(16) "confirm_password"
      [10]=>
      string(6) "delete"
      [11]=>
    }

   //важно! название доступного класса должно совпадать с названием метода в классе





#### Параметр доступа для гостей
    ["guest"]=>
    array(0) {
    }
    ["admin"]=>
    array(1) {
      [0]=>
      string(11) "create_user" //метод
    }
  }

    //важно! название доступного класса должно совпадать с названием метода в классе





#### Параметр адреса подключения файлов моделей 

    ['model']=>

    object(App\Models\Users)#5 (1)
    {

        ["db"]=>
        object(Database\QueryBuilder)#6 (1) {
        ["pdo":protected]=>
        object(PDO)#7 (0) {
        }
        }
    }
    }





### Далее файлы App/Acl/'название файла'. обрабатывает параметр доступа к контроллерам и методам в зависимости от ролей пользователей:

    ["acl"]=>

    array(4) {

        ["all"]=>
        array(1) {
        [0]=>
        string(5) "users" //метод
        }

    //важно! название доступного класса должно совпадать с названием метода в классе





#### С помощью параметра 'route' происходит обращение к необходимому классу и методу, в примере это:

    ["route"]=>

    array(3) {

        ["controller"]=>
        string(5) "users" // класс
        ["action"]=>
        string(12) "user_profile" //метод
        ["id"]=>
        int(1) //параметр обращения 

    }

//Далее Класс "users" к которому направлен запрос и соответсвующий метод "user_profile" производят действия по обработке запроса int(1). 






#### Класс/метод файла  контролллера  используют методы из моделей классов, в прмере подключается файл с классом App\Models\Users.php и выполняет метод выполнения запроса из базы данных польщзователя с 'id' = 1, метод в свою очередь обращается к классу Database\QueryBuilder построитель запросов:

    ["model"]=>

    object(App\Models\Users)#5 (1) {

        ["db"]=>
        object(Database\QueryBuilder)#6 (1) {
        ["pdo":protected]=>
        object(PDO)#7 (0) {
        }
        }
    }
    }


//получаенные данные из БД и передаются в подключенный файл шаблона и страницы вида





### Создается объект вида шаблона и страницы с помощью класса App\Core\View.  

    ["view"]=>

    object(App\Core\View)#4 (3) {

        ["pach"]=>
        string(18) "users/user_profile" //параметр обращения к файлам вида
        ["layout"]=>
        string(7) "default" //важно! название шаблона вида в параметре должно совпадать с названием файла видла без учета расширения default.php
        ["route"]=>
        array(3) {
        ["controller"]=>
        string(5) "users" //важно! название контролера в параметре должно совпадать с названием класса 'UsersController' и названием файла класса без учета расширения 'UsersController.php'
        ["action"]=>
        string(12) "user_profile" //важно! название контролера в параметре должно совпадать с названием метода 'user_profile' и названием файла подключения страницы виды к шаблону вида  без учета расширения 'user_profile.php'
        ["id"]=>
        int(1)
        }
    }




## 5. Краткая инструкция для развертывания проекта у себя

### Проект настроен для работы на  веб-сервере  Apache
Для развертывания проекта понадобиться провести настройки окружения.
Если ваш сервер Apache  в файле App/database/config.php нужно записать свои параметры конфигурации подключения к БД

    return 
    [
        "database" => 
        [

            "database" => "....", //заполнить

            "username" => "....",//заполнить

            "password" => "....",//заполнить

            "connection" => "......",//заполнить, напрмер если у вас Mac нужно записать 'mysql:host=localhost:8889'

            "charset" => "utf8"

                ]

            ];

Если у вас другой веб-сервер, потребуются другие настройки конфигурации подключения.

### Размещение проекта
Скопируйте проект из репозитория  github и разместите у себя в папке веб-сервера

### Если ваш веб-сервер Apache в папке в которой размещена папка проекта разместите файл .htaccess
В файле запишите код:
AddDefaultCharset utf-8
RewriteEngine On
RewriteRule (.*) lesson-project-php-mvc/public/$1 

### В проекте приложен файл exampdb.sql из которого можно импортировать таблицы БД
В таблице БД имеются пользователи проекта с установленными ролями "admin" и "superadmin:
- otto@otto.
- viky@viky.
- morzav@morzav.
- sandra@sandra.
- vladi@vladi.
Пароль у всех перечисленных пользователей 123aaa.

Экспортируйте  данные из файла exampdb.aql в phpMyAdmin.

Спасибо за просмотр! Желаю всем успехов!

