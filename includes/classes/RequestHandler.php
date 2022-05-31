<?php

namespace Bjercke;

use Bjercke\Entity\Article;
use Bjercke\Entity\Forum\Post;
use Bjercke\Entity\Page;
use Bjercke\Entity\TileOption;
use Bjercke\Entity\User;
use Bjercke\Entity\Tile;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;
use Forum;
use FroalaEditor_Image;
use NewTileTile;

class RequestHandler {
    private SqlConnection $db;

    public function __construct() {
        $this->db = SqlConnection::getInstance();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws TransactionRequiredException
     */
    public function handleRequest(): void {
        $action = $_REQUEST['action'];

        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'register':
                $this->registration();
                break;
            case 'profile_upload':
                $this->uploadProfilePicture();
                break;
            case 'forum_post':
                $this->forumPost();
                break;
            case 'upload_image':
                $this->uploadImage();
                break;
            case 'load_images':
                $this->loadImages();
                break;
            case 'delete_image':
                $this->deleteImage();
                break;
            case 'cron_job':
                $this->cronJob();
                break;
            case 'new_article':
                $this->newArticle();
                break;
            case 'new_tile':
                $this->newTile();
                break;
            case 'new_page':
                $this->newPage();
                break;
            case 'render_tile_list':
                $this->renderTileList();
                break;
            case 'render_tile':
                $this->renderTile();
                break;
            case 'pagebuilder_save_page':
                $this->pageBuilderSavePage();
                break;
            case 'pagebuilder_save_tile':
                $this->pageBuilderSaveTile();
                break;
            case 'get_language_string':
                $this->getLanguageString();
                break;
            default:
                echo "Invalid action.";
                break;
        }
    }

    private function login(): void {
        $username = filter_var($_POST['username'], FILTER_UNSAFE_RAW) ?? '';
        $password = filter_var($_POST['password'], FILTER_UNSAFE_RAW) ?? '';

        // Validate all fields before continuing
        if (!$username || !$password) {
            echo "0";

            return;
        }

        $em = $this->db->getEntityManager();
        $result = $em
            ->getRepository(User::class)
            ->findOneBy(['username' => $username, 'password' => $password]);

        if ($result) {
            $result->setLoggedIn(true);
            $em->flush();
            $userStorage = new WebStorage('user', serialize($result), (7 * 24 * 60 * 60));
            $userStorage->save();
            $actionStorage = new WebStorage('action');
            $actionStorage->setSessionValue("success");
            $response = [
                'action'  => 'success',
                'message' => 'Logged in successfully.'
            ];
            $this->responseJson($response);
        } else {
            $response = [
                'action'  => 'error',
                'message' => 'Invalid username or password.'
            ];
            $this->responseJson($response);
        }
    }

    /**
     * @throws ORMException
     */
    private function registration(): void {
        $username = filter_var($_POST['username'], FILTER_UNSAFE_RAW) ?? '';
        $password = filter_var($_POST['password'], FILTER_UNSAFE_RAW) ?? '';
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ?? '';

        // Validate all fields before continuing
        if (!$username || !$password || !$email) {
            $response = [
                'action'  => 'error',
                'message' => 'All fields must be valid.'
            ];

            $this->responseJson($response);

            return;
        }

        $this->db->registerUser($username, $password, $email);

        $response = [
            'action'  => 'success',
            'message' => 'Account was created successfully.'
        ];

        $actionStorage = new WebStorage('action');
        $actionStorage->setSessionValue("success");

        $this->responseJson($response);
    }

    /**
     * @return void
     */
    private function uploadProfilePicture(): void {
        $file = new FileUpload($_FILES['file']);
        $image = $file->imageCheck();
        $size = $file->sizeCheck(2097152); // 2MB
        $error = $file->errorCheck();

        if (!$image) {
            // Is not an image
            echo "-1";

            return;
        }

        if (!$size) {
            // File is too large
            echo "-2";

            return;
        }

        if ($error) {
            // File upload error
            echo "-3";

            return;
        }

        if ($file->upload("img/avatars/")) {
            echo "1";
        } else {
            echo "0";
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    private function forumPost(): void {
        $title = filter_var($_POST['title'], FILTER_UNSAFE_RAW) ?? '';
        $content = filter_var($_POST['content'], FILTER_UNSAFE_RAW) ?? '';

        // Validate all fields before continuing
        if (!$title || !$content) {
            echo "0";

            return;
        }

        $currentUser = Site::getInstance()->getCurrentUser();
        $em = $this->db->getEntityManager();

        $userEntity = $em->find(User::class, $currentUser->getId());

        $forumPost = (new Post())
            ->setTitle($title)
            ->setContent($content)
            ->setAuthor($userEntity)
            ->setDate(time());

        Forum::getInstance()->createPost($forumPost);

        $response = [
            'action'   => 'success',
            'title'    => $forumPost->getTitle(),
            'content'  => $forumPost->getContent(),
            'author'   => $forumPost->getAuthor()->getUsername(),
            'date'     => $forumPost->getDate(),
            'time_ago' => $forumPost->getTimeAgo()
        ];
        $this->responseJson($response);
    }

    /**
     * @throws \JsonException
     */
    private function responseJson($response): void {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response, JSON_THROW_ON_ERROR);
    }

    private function uploadImage(): void {
        $response = FroalaEditor_Image::upload('/img/uploads/');
        $this->responseJson($response);
    }

    private function loadImages(): void {
        $response = FroalaEditor_Image::getList('/img/uploads/');
        $this->responseJson($response);
    }

    private function deleteImage(): void {
        $response = FroalaEditor_Image::delete($_REQUEST['src']);
        $this->responseJson($response);
    }

    private function cronJob(): void {
        $cronAction = $_REQUEST['cron_action'];

        switch ($cronAction) {
            case 'get_users':

                /** @var User[] $users */
                $users = $this->db->getUsers();

                foreach ($users as $user) {
                    $newUser = [
                        'id'       => $user->getId(),
                        'username' => $user->getUsername(),
                        'email'    => $user->getEmail(),
                    ];
                    $newUsers[] = $newUser;
                }

                $response = [
                    'action' => 'success',
                    'users'  => $newUsers ?? []
                ];
                break;
            default:
                break;
        }

        $this->responseJson($response ?? []);
    }

    private function newArticle(): void {
        $title = filter_var($_REQUEST['title'], FILTER_UNSAFE_RAW) ?? '';
        $content = filter_var($_REQUEST['content'], FILTER_UNSAFE_RAW) ?? '';
        $backgroundCheck = filter_var($_REQUEST['background_check'], FILTER_UNSAFE_RAW) ?? '';

        $upload = false;

        if ($backgroundCheck === "true") {
            $file = new FileUpload($_FILES['background_file']);
            $image = $file->imageCheck();
            $size = $file->sizeCheck(2097152); // 2MB
            $error = $file->errorCheck();

            if (!$image) {
                // Is not an image
                echo "-1";

                return;
            }

            if (!$size) {
                // File is too large
                echo "-2";

                return;
            }

            if ($error) {
                // File upload error
                echo "-3";

                return;
            }

            if ($file->upload(__DIR__ . "/../../uploads/")) {
                $upload = true;
            } else {
                echo "0";
                return;
            }
        }

        // Validate all fields before continuing
        if (!$title || !$content) {
            echo "0";

            return;
        }

        $currentUser = Site::getInstance()->getCurrentUser();
        $em = $this->db->getEntityManager();

        $userEntity = $em->find(User::class, $currentUser->getId());

        $article = (new Article())
            ->setTitle($title)
            ->setContent($content)
            ->setAuthor($userEntity)
            ->setDate(time());

        if ($upload) {
            $article->setHasBackground(true);
            $article->setBackgroundImage($file->getFileNewName());
        } else {
            $article->setHasBackground(false);
        }

        $em->persist($article);
        $em->flush();

        $response = [
            'action'  => 'success',
            'message' => 'The article was posted successfully.'
        ];

        $this->responseJson($response);
    }

    private function newTile(): void {
        $title = filter_var($_REQUEST['title'], FILTER_UNSAFE_RAW) ?? '';
        $templatePath = $_REQUEST['template_path'];
        $className = $_REQUEST['class_name'];

        if (!$title) {
            echo "0";

            return;
        }

        $tile = new Tile($title, $templatePath, $className);

        $em = $this->db->getEntityManager();
        $em->persist($tile);
        $em->flush();

        $response = [
            'action'  => 'success',
            'message' => 'The tile was added successfully.'
        ];

        $this->responseJson($response);
    }

    private function newPage() {
        $name = filter_input(INPUT_POST, 'name', FILTER_UNSAFE_RAW) ?? '';
        $title = filter_input(INPUT_POST, 'title', FILTER_UNSAFE_RAW) ?? '';
        $description = filter_input(INPUT_POST, 'description', FILTER_UNSAFE_RAW) ?? '';
        $icon = filter_input(INPUT_POST, 'icon', FILTER_UNSAFE_RAW) ?? '';
        $url = filter_input(INPUT_POST, 'url', FILTER_UNSAFE_RAW) ?? '';
        $template = filter_input(INPUT_POST, 'template', FILTER_UNSAFE_RAW) ?? '';
        $class = filter_input(INPUT_POST, 'class', FILTER_UNSAFE_RAW) ?? '';
        $navigation = filter_input(INPUT_POST, 'navigation', FILTER_VALIDATE_BOOLEAN) ?? false;
        $requiresLogin = filter_input(INPUT_POST, 'requires_login', FILTER_VALIDATE_BOOLEAN) ?? false;

        if (!$name || !$title || !$description || !$icon || !$url || !$template || !$class) {
            $response = [
                'action'  => 'error',
                'message' => 'All fields are required.'
            ];

            $this->responseJson($response);

            return;
        }

        $page = new Page($name, $title, $description, $icon, $url, $template, $class, $navigation, $requiresLogin);
        $em = $this->db->getEntityManager();
        $em->persist($page);
        $em->flush();

        $response = [
            'action'  => 'success',
            'message' => 'The page was added successfully.',
        ];

        $this->responseJson($response);
    }

    private function renderTileList() {
        $tileList = NewTileTile::getInstance()->renderTileList();
        echo $tileList;
    }

    /**
     * Helper function for rendering tiles with AJAX.
     *
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    private function renderTile(): bool|string {
        $tileId = $_REQUEST['tile_id'];

        $em = $this->db->getEntityManager();
        $tile = $em->find(Tile::class, $tileId);

        $templatePath = $tile->getTemplatePath();
        $className = $tile->getClassName();
        $view = TileRenderer::getInstance();
        ob_start();
        $view->renderTilePiece($className, $templatePath);

        return ob_get_flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws TransactionRequiredException
     * @throws \JsonException
     */
    private function pageBuilderSavePage() {
        $pageId = $_REQUEST['page_id'];
        $order = $_REQUEST['order'];

        $orderArray = explode(',', $order);

        if ($orderArray[0] === '') {
            $orderArray = [];
        }

        $em = $this->db->getEntityManager();
        $page = $em->find(Page::class, $pageId);

        if ($page instanceof Page) {
            $page->setTileOrder($orderArray);
            $em->flush();
            $action = 'success';
        }

        $response = [
            'action'  => $action ?? 'error',
            'order'   => $order,
            'page_id' => $pageId
        ];

        $this->responseJson($response);
    }

    private function pageBuilderSaveTile()
    {
        $tileId = (int) $_REQUEST['tile_id'];
        $articleId = (int) $_REQUEST['article_id'];

        $em = $this->db->getEntityManager();
        $tile = $em->find(Tile::class, $tileId);

        if ($articleId === 0) {
            if ($tile instanceof Tile) {
                $tile->setArticle(null);
                $em->flush();

                $response = [
                    'action'  => 'success',
                ];
            }

            $this->responseJson($response);
            return;
        }

        $article = $em->find(Article::class, $articleId);

        if ($tile instanceof Tile && $article instanceof Article) {
            $tile->setArticle($article);
            $em->flush();

            $response = [
                'action'  => 'success',
            ];
        } else {
            $response = [
                'action'  => 'error',
            ];
        }

        $this->responseJson($response);
    }

    private function getLanguageString()
    {
        $string = $_REQUEST['string'];

        echo Site::getInstance()->getString($string);
    }
}
