<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

// Initialisation de certaines choses
use App\Controller\ContactController;
use App\Controller\ProductListController;
use App\Controller\IndexController;
use App\Controller\ApiController;
use App\Controller\backEndController;
use App\Controller\cartController;
use App\DependencyInjection\Container;
use App\Routing\RouteNotFoundException;
use App\Routing\Router;
use App\Routing\ArgumentResolver;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env');

if (
  php_sapi_name() !== 'cli' && // Environnement d'exécution != console
  preg_match('/\.(ico|png|jpg|jpeg|css|js|gif|woff2|svg|webp)$/', $_SERVER['REQUEST_URI'])
) {
  return false;
}

// DB
[
  'DB_HOST'     => $host,
  'DB_PORT'     => $port,
  'DB_NAME'     => $dbname,
  'DB_CHARSET'  => $charset,
  'DB_USER'     => $user,
  'DB_PASSWORD' => $password
] = $_ENV;

$dsn = "mysql:dbname=$dbname;host=$host:$port;charset=$charset";

try {
  $pdo = new PDO($dsn, $user, $password);
  // var_dump($pdo);
} catch (PDOException $ex) {
  echo "Erreur lors de la connexion à la base de données : " . $ex->getMessage();
  exit;
}

// Twig
$loader = new FilesystemLoader(__DIR__ . '/../templates/');
$twig = new Environment($loader, [
  'debug' => $_ENV['APP_ENV'] === 'dev',
  'cache' => __DIR__ . '/../var/twig/',
]);

$serviceContainer = new Container();
$serviceContainer
  ->set(Environment::class, $twig)
  ->set(PDO::class, $pdo)
  ->set(App\Models\ProductModel::class, new App\Models\ProductModel($pdo))
  ->set(App\Models\CategoryModel::class, new App\Models\CategoryModel($pdo))
  ->set(App\Models\GemTypeModel::class, new App\Models\GemTypeModel($pdo))
  ->set(App\Models\CollectionModel::class, new App\Models\CollectionModel($pdo))
  ->set(App\Models\LoginModel::class, new App\Models\LoginModel($pdo))
  ->set(App\Models\RegisterModel::class, new App\Models\RegisterModel($pdo))
  ->set(App\Models\CartModel::class, new App\Models\CartModel($pdo))
  ->set(App\Models\OrderModel::class, new App\Models\OrderModel($pdo));
  
// Appeler un routeur pour lui transférer la requête
$router = new Router($serviceContainer, new ArgumentResolver());
$router->registerRoutes();

// Enregistrer la route de déconnexion
Router::registerLogoutRoute($router);

try {
  $router->execute($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (RouteNotFoundException $ex) {
  http_response_code(404);
  echo "Page not found";
}
