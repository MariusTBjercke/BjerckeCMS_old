<?php

namespace Bjercke;

use Bjercke\Entity\User;
use Bjercke\Enum\AddonLevel;
use Bjercke\Enum\AccountLevel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Tools\Setup;
use Exception;
use Singleton;

/**
 * BjerckeCMS SQL connection class.
 */
class SqlConnection extends Singleton {
    private static array $instances = [];
    private string $hostname;
    private string $username;
    private string $password;
    private string $database;
    private array $connectionParams;
    private EntityManager $entityManager;

    /**
     * Constructor.
     *
     * @throws Exception
     */
    protected function __construct() {
        parent::__construct();

        $this->hostname = $_ENV['SQL_HOSTNAME'];
        $this->username = $_ENV['SQL_USERNAME'];
        $this->password = $_ENV['SQL_PASSWORD'];
        $this->database = $_ENV['SQL_DATABASE'];
        $this->setConnectionParams();
        $this->entityManager = EntityManager::create(
            $this->connectionParams,
            Setup::createAnnotationMetadataConfiguration([__DIR__ . '/Doctrine/Entity'], developmentMode)
        );
    }

    /**
     * Returns a user array from the database.
     *
     * @return array
     */
    public function getUsers(): array {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    /**
     * @throws ORMException
     */
    public function registerUser(string $username, string $password, string $email, bool $isAdmin = false): void {
        $user = (new User())
            ->setUsername($username)
            ->setPassword($password)
            ->setEmail($email)
            ->setAddonLevel(AddonLevel::WotLK)
            ->setAccountLevel(AccountLevel::Admin)
            ->setIsAdmin($isAdmin);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @return array
     */
    public function getConnectionParams(): array {
        return $this->connectionParams;
    }

    public function setConnectionParams(): void {
        $this->connectionParams = [
            'dbname'   => $this->database,
            'user'     => $this->username,
            'password' => $this->password,
            'host'     => $this->hostname,
            'driver'   => 'pdo_mysql',
        ];
    }

    /**
     * @return mixed|string
     */
    public function getHostname() {
        return $this->hostname;
    }

    /**
     * @param mixed|string $hostname
     */
    public function setHostname($hostname): void {
        $this->hostname = $hostname;
    }

    /**
     * @return mixed|string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param mixed|string $username
     */
    public function setUsername($username): void {
        $this->username = $username;
    }

    /**
     * @return mixed|string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed|string $password
     */
    public function setPassword($password): void {
        $this->password = $password;
    }

    /**
     * @return mixed|string
     */
    public function getDatabase() {
        return $this->database;
    }

    /**
     * @param mixed|string $database
     */
    public function setDatabase($database): void {
        $this->database = $database;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager {
        return $this->entityManager;
    }
}