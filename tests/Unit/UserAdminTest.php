<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Database;
use App\Models\User;
use App\Repositories\PdoUserRepository;

class UserAdminTest extends TestCase {
    private \PDO $pdo;
    private PdoUserRepository $userRepo;

    protected function setUp(): void {
        $this->pdo = Database::getInstance();
        $this->userRepo = new PdoUserRepository($this->pdo);

        // Réinitialiser la table users pour un environnement de test prédictible
        $this->pdo->exec("DELETE FROM users");
        $this->pdo->exec("
            INSERT INTO users (id, username, email, password, role, created_at)
            VALUES (1, 'root_admin', 'root@djerbavoyage.tn', '\$2y\$10\$abcdefghijklmnopqrstuv', 'admin', CURRENT_TIMESTAMP)
        ");
    }

    public function testFindInitialAdminUser() {
        $user = $this->userRepo->findById(1);
        $this->assertNotNull($user);
        $this->assertEquals('root_admin', $user->username);
        $this->assertEquals('root@djerbavoyage.tn', $user->email);
        $this->assertEquals('admin', $user->role);
    }

    public function testFindByUsernameAndEmail() {
        $byUser = $this->userRepo->findByUsername('root_admin');
        $this->assertNotNull($byUser);
        $this->assertEquals(1, $byUser->id);

        $byEmail = $this->userRepo->findByEmail('root@djerbavoyage.tn');
        $this->assertNotNull($byEmail);
        $this->assertEquals(1, $byEmail->id);

        $this->assertNull($this->userRepo->findByUsername('nonexistent'));
        $this->assertNull($this->userRepo->findByEmail('nonexistent@test.tn'));
    }

    public function testCreateNewUser() {
        $newUser = new User(
            id: null,
            username: 'editor_marie',
            email: 'marie@djerbavoyage.tn',
            password: password_hash('Secret123!', PASSWORD_BCRYPT),
            role: 'editor'
        );

        $created = $this->userRepo->create($newUser);
        $this->assertTrue($created);

        $retrieved = $this->userRepo->findByUsername('editor_marie');
        $this->assertNotNull($retrieved);
        $this->assertEquals('marie@djerbavoyage.tn', $retrieved->email);
        $this->assertEquals('editor', $retrieved->role);
        $this->assertTrue(password_verify('Secret123!', $retrieved->password));

        $count = $this->userRepo->count();
        $this->assertEquals(2, $count);
    }

    public function testUpdateUserWithoutPassword() {
        $user = $this->userRepo->findById(1);
        $this->assertNotNull($user);

        $user->username = 'super_admin';
        $user->email    = 'super@djerbavoyage.tn';
        $user->role     = 'admin';

        $updated = $this->userRepo->update($user);
        $this->assertTrue($updated);

        $refreshed = $this->userRepo->findById(1);
        $this->assertEquals('super_admin', $refreshed->username);
        $this->assertEquals('super@djerbavoyage.tn', $refreshed->email);
        $this->assertEquals('$2y$10$abcdefghijklmnopqrstuv', $refreshed->password);
    }

    public function testUpdateUserWithPasswordChange() {
        $user = $this->userRepo->findById(1);
        $newHash = password_hash('NewSecurePassword!2026', PASSWORD_BCRYPT);

        $updated = $this->userRepo->update($user, $newHash);
        $this->assertTrue($updated);

        $refreshed = $this->userRepo->findById(1);
        $this->assertTrue(password_verify('NewSecurePassword!2026', $refreshed->password));
    }

    public function testDeleteUser() {
        $newUser = new User(
            id: null,
            username: 'temp_user',
            email: 'temp@djerbavoyage.tn',
            password: 'hash',
            role: 'agent'
        );
        $this->userRepo->create($newUser);
        $created = $this->userRepo->findByUsername('temp_user');
        $this->assertNotNull($created);

        $deleted = $this->userRepo->delete($created->id);
        $this->assertTrue($deleted);

        $this->assertNull($this->userRepo->findById($created->id));
        $this->assertEquals(1, $this->userRepo->count());
    }

    public function testGetAllReturnsArrayOfUserInstances() {
        $all = $this->userRepo->getAll();
        $this->assertIsArray($all);
        $this->assertEquals(1, count($all));
        $this->assertTrue($all[0] instanceof User);
    }
}
