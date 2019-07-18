<?php
declare(strict_types=1);
namespace Models;

use Core\Model;

/**
 * Class User
 *
 * @package Models
 */
class User extends Model
{
    /** @var string $table */
    protected $table = 'users';

    /** @var int $id */
    public $id = 1;
    /** @var string $login */
    public $login = 'admin';

    /**
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function create(array $params): array
    {
        return ['id' => $this->id, 'error' => null];
    }

    /**
     * @inheritDoc
     */
    public function edit(int $id, array $params): array
    {
        return ['id' => $this->id, 'error' => null];
    }
}
