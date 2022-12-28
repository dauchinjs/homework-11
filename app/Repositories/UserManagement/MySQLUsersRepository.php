<?php

namespace App\Repositories\UserManagement;

use App\Models\UserStockModel;
use App\Services\Database;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class MySQLUsersRepository implements UsersRepository
{
    private Connection $connection;
    private QueryBuilder $queryBuilder;

    public function __construct()
    {
        $this->connection = Database::getConnection();
        $this->queryBuilder = $this->connection->createQueryBuilder();
    }
    public function getByEmail(string $email): ?array
    {
        $user = $this->queryBuilder
            ->select('*')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $email)
            ->fetchAssociative();
        return $user ?: null;
    }

    public function getByID(int $id): ?array
    {
        $user = $this->queryBuilder
            ->select('*')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->fetchAssociative();
        return $user ?: null;
    }

    public function getUserStocks(int $id): ?array
    {
        $userStocks = $this->queryBuilder
            ->select('*')
            ->from('stocks')
            ->where('user_id = ?')
            ->setParameter(0, $id)
            ->fetchAllAssociative();
        return $userStocks ?: null;
    }

    public function getAmountOwned(int $id, string $symbol): ?int
    {
        $amountOwned = $this->queryBuilder
            ->select('amount')
            ->from('stocks')
            ->where('user_id = ?')
            ->andWhere('symbol = ?')
            ->setParameter(0, $id)
            ->setParameter(1, $symbol)
            ->fetchOne();
        return $amountOwned ?: null;
    }
    public function getBalance(int $id): ?float
    {
        $balance = $this->queryBuilder
            ->select('balance')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->fetchOne();
        return $balance ?: null;
    }

    public function getUserStock(int $id, string $symbol): ?UserStockModel
    {
        $userStock = $this->queryBuilder
            ->select('*')
            ->from('stocks')
            ->where('user_id = ?')
            ->andWhere('symbol = ?')
            ->setParameter(0, $id)
            ->setParameter(1, $symbol)
            ->fetchAssociative();
        if(!$userStock) {
            return null;
        }
        return new UserStockModel(
            $userStock['user_id'],
            $userStock['symbol'],
            $userStock['amount'],
            $userStock['price'],
        );
    }
}