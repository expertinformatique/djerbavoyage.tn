<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Router;
use Core\Container;

class RouterTest extends TestCase {
    private Router $router;
    private Container $container;
    private array $serverBackup;

    protected function setUp(): void {
        $this->router = new Router();
        $this->container = new Container();
        $this->serverBackup = $_SERVER;
    }

    protected function tearDown(): void {
        $_SERVER = $this->serverBackup;
    }

    public function testStandardRouteDispatch() {
        $this->router->get('/', function() {
            return 'home_ok';
        });

        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $result = $this->router->dispatch('GET', '/', $this->container);

        $this->assertEquals('home_ok', $result);
    }

    public function testSubfolderTransparentRewriteDispatch() {
        $this->router->get('/guide', function() {
            return 'guide_ok';
        });

        // Simule Laragon où SCRIPT_NAME pointe vers public/index.php mais l'URI demandée est /djerbavoyage/guide
        $_SERVER['SCRIPT_NAME'] = '/djerbavoyage/public/index.php';
        $result = $this->router->dispatch('GET', '/djerbavoyage/guide', $this->container);

        $this->assertEquals('guide_ok', $result);
    }

    public function testSubfolderWithPublicDispatch() {
        $this->router->get('/guide', function() {
            return 'guide_public_ok';
        });

        // Simule un accès direct via /djerbavoyage/public/guide
        $_SERVER['SCRIPT_NAME'] = '/djerbavoyage/public/index.php';
        $result = $this->router->dispatch('GET', '/djerbavoyage/public/guide', $this->container);

        $this->assertEquals('guide_public_ok', $result);
    }

    public function testDomainRootRewriteDispatch() {
        $this->router->get('/activites', function() {
            return 'activites_ok';
        });

        // Simule djerbavoyage.tn avec DocumentRoot à la racine du projet
        $_SERVER['SCRIPT_NAME'] = '/public/index.php';
        $result = $this->router->dispatch('GET', '/activites', $this->container);

        $this->assertEquals('activites_ok', $result);
    }

    public function testRouteWithParameter() {
        $this->router->get('/guide/{slug}', function($slug) {
            return "article_$slug";
        });

        $_SERVER['SCRIPT_NAME'] = '/djerbavoyage/public/index.php';
        $result = $this->router->dispatch('GET', '/djerbavoyage/guide/visiter-djerba', $this->container);

        $this->assertEquals('article_visiter-djerba', $result);
    }
}
