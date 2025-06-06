<?php

namespace Hoyvoy\Tests\Integration;

use Hoyvoy\CrossDatabase\Eloquent\Model as Model;
use Hoyvoy\Tests\TestCase;

class DatabaseEloquentSubqueriesCrossDatabaseTest extends TestCase
{
    public function testWhereHasAcrossDatabaseConnection()
    {
        // Test MySQL cross database subquery
        $query = UserMysql::whereHas('orders', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from `users` where exists (select * from `mysql2`.`'.$this->tablesPrefix.'orders` as `1orders` where `users`.`id` = `orders`.`user_id` and `name` like ?)', $query->toSql());

        // Test MySQL same database subquery
        $query = UserMysql::whereHas('posts', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from `users` where exists (select * from `posts` where `users`.`id` = `posts`.`user_id` and `name` like ?)', $query->toSql());

        // Test PostgreSQL cross database subquery
        $query = UserPgsql::whereHas('orders', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from "users" where exists (select * from "pgsql2"."'.$this->tablesPrefix.'orders" as "1orders" where "users"."id" = "orders"."user_id" and "name"::text like ?)', $query->toSql());

        // Test PostgreSQL same database subquery
        $query = UserPgsql::whereHas('posts', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from "users" where exists (select * from "posts" where "users"."id" = "posts"."user_id" and "name"::text like ?)', $query->toSql());

        // Test SQL Server cross database subquery
        $query = UserSqlsrv::whereHas('orders', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from [users] where exists (select * from [sqlsrv2].['.$this->tablesPrefix.'orders] as [1orders] where [users].[id] = [orders].[user_id] and [name] like ?)', $query->toSql());

        // Test SQL Server same database subquery
        $query = UserSqlsrv::whereHas('posts', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from [users] where exists (select * from [posts] where [users].[id] = [posts].[user_id] and [name] like ?)', $query->toSql());

        // Test SQL Server cross database subquery
        $query = UserSqlite::whereHas('orders', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from "users" where exists (select * from "orders" where "users"."id" = "orders"."user_id" and "name" like ?)', $query->toSql());

        // Test SQL Server same database subquery
        $query = UserSqlite::whereHas('posts', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from "users" where exists (select * from "posts" where "users"."id" = "posts"."user_id" and "name" like ?)', $query->toSql());
    }

    public function testHasAcrossDatabaseConnection()
    {
        // Test MySQL cross database subquery
        $query = UserMysql::has('orders');
        $this->assertEquals('select * from `users` where exists (select * from `mysql2`.`'.$this->tablesPrefix.'orders` as `1orders` where `users`.`id` = `orders`.`user_id`)', $query->toSql());

        // Test MySQL same database subquery
        $query = UserMysql::has('posts');
        $this->assertEquals('select * from `users` where exists (select * from `posts` where `users`.`id` = `posts`.`user_id`)', $query->toSql());

        // Test PostgreSQL cross database subquery
        $query = UserPgsql::has('orders');
        $this->assertEquals('select * from "users" where exists (select * from "pgsql2"."'.$this->tablesPrefix.'orders" as "1orders" where "users"."id" = "orders"."user_id")', $query->toSql());

        // Test PostgreSQL same database subquery
        $query = UserPgsql::has('posts');
        $this->assertEquals('select * from "users" where exists (select * from "posts" where "users"."id" = "posts"."user_id")', $query->toSql());

        // Test SQL Server cross database subquery
        $query = UserSqlsrv::has('orders');
        $this->assertEquals('select * from [users] where exists (select * from [sqlsrv2].['.$this->tablesPrefix.'orders] as [1orders] where [users].[id] = [orders].[user_id])', $query->toSql());

        // Test SQL Server same database subquery
        $query = UserSqlsrv::has('posts');
        $this->assertEquals('select * from [users] where exists (select * from [posts] where [users].[id] = [posts].[user_id])', $query->toSql());

        // Test SQL Server cross database subquery
        $query = UserSqlite::has('orders');
        $this->assertEquals('select * from "users" where exists (select * from "orders" where "users"."id" = "orders"."user_id")', $query->toSql());

        // Test SQL Server same database subquery
        $query = UserSqlite::has('posts');
        $this->assertEquals('select * from "users" where exists (select * from "posts" where "users"."id" = "posts"."user_id")', $query->toSql());
    }

    public function testDoesntHasAcrossDatabaseConnection()
    {
        // Test MySQL cross database subquery
        $query = UserMysql::doesntHave('orders');
        $this->assertEquals('select * from `users` where not exists (select * from `mysql2`.`'.$this->tablesPrefix.'orders` as `1orders` where `users`.`id` = `orders`.`user_id`)', $query->toSql());

        // Test MySQL same database subquery
        $query = UserMysql::doesntHave('posts');
        $this->assertEquals('select * from `users` where not exists (select * from `posts` where `users`.`id` = `posts`.`user_id`)', $query->toSql());

        // Test PostgreSQL cross database subquery
        $query = UserPgsql::doesntHave('orders');
        $this->assertEquals('select * from "users" where not exists (select * from "pgsql2"."'.$this->tablesPrefix.'orders" as "1orders" where "users"."id" = "orders"."user_id")', $query->toSql());

        // Test PostgreSQL same database subquery
        $query = UserPgsql::doesntHave('posts');
        $this->assertEquals('select * from "users" where not exists (select * from "posts" where "users"."id" = "posts"."user_id")', $query->toSql());

        // Test SQL Server cross database subquery
        $query = UserSqlsrv::doesntHave('orders');
        $this->assertEquals('select * from [users] where not exists (select * from [sqlsrv2].['.$this->tablesPrefix.'orders] as [1orders] where [users].[id] = [orders].[user_id])', $query->toSql());

        // Test SQL Server same database subquery
        $query = UserSqlsrv::doesntHave('posts');
        $this->assertEquals('select * from [users] where not exists (select * from [posts] where [users].[id] = [posts].[user_id])', $query->toSql());

        // Test SQL Server cross database subquery
        $query = UserSqlite::doesntHave('orders');
        $this->assertEquals('select * from "users" where not exists (select * from "orders" where "users"."id" = "orders"."user_id")', $query->toSql());

        // Test SQL Server same database subquery
        $query = UserSqlite::doesntHave('posts');
        $this->assertEquals('select * from "users" where not exists (select * from "posts" where "users"."id" = "posts"."user_id")', $query->toSql());
    }

    public function testWhereDoesntHaveAcrossDatabaseConnection()
    {
        // Test MySQL cross database subquery
        $query = UserMysql::whereDoesntHave('orders', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from `users` where not exists (select * from `mysql2`.`'.$this->tablesPrefix.'orders` as `1orders` where `users`.`id` = `orders`.`user_id` and `name` like ?)', $query->toSql());

        // Test MySQL same database subquery
        $query = UserMysql::whereDoesntHave('posts', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from `users` where not exists (select * from `posts` where `users`.`id` = `posts`.`user_id` and `name` like ?)', $query->toSql());

        // Test PostgreSQL cross database subquery
        $query = UserPgsql::whereDoesntHave('orders', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from "users" where not exists (select * from "pgsql2"."'.$this->tablesPrefix.'orders" as "1orders" where "users"."id" = "orders"."user_id" and "name"::text like ?)', $query->toSql());

        // Test PostgreSQL same database subquery
        $query = UserPgsql::whereDoesntHave('posts', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from "users" where not exists (select * from "posts" where "users"."id" = "posts"."user_id" and "name"::text like ?)', $query->toSql());

        // Test SQL Server cross database subquery
        $query = UserSqlsrv::whereDoesntHave('orders', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from [users] where not exists (select * from [sqlsrv2].['.$this->tablesPrefix.'orders] as [1orders] where [users].[id] = [orders].[user_id] and [name] like ?)', $query->toSql());

        // Test SQL Server same database subquery
        $query = UserSqlsrv::whereDoesntHave('posts', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from [users] where not exists (select * from [posts] where [users].[id] = [posts].[user_id] and [name] like ?)', $query->toSql());

        // Test SQL Server cross database subquery
        $query = UserSqlite::whereDoesntHave('orders', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from "users" where not exists (select * from "orders" where "users"."id" = "orders"."user_id" and "name" like ?)', $query->toSql());

        // Test SQL Server same database subquery
        $query = UserSqlite::whereDoesntHave('posts', function ($query) {
            $query->where('name', 'like', '%a%');
        });
        $this->assertEquals('select * from "users" where not exists (select * from "posts" where "users"."id" = "posts"."user_id" and "name" like ?)', $query->toSql());
    }

    /**
     * @todo support prefixes
     */
    public function testWithCountAcrossDatabaseConnection()
    {
        // Test MySQL cross database subquery ()
        $query = UserMysql::withCount(['ordersWithoutPrefix' => function ($query) {
            $query->where('name', 'like', '%a%');
        },
        ]);

        $sql = $query->toSql();

        $this->assertMatchesRegularExpression('/from `mysql3`\.(?:`mysql3`\.)?`orders`/', $sql);
        $this->assertStringContainsString('count(*)', $sql);
        $this->assertStringContainsString('`name` like ?', $sql);

        // Test MySQL same database subquery
        $query = UserMysql::withCount(['posts' => function ($query) {
            $query->where('name', 'like', '%a%');
        },
        ]);
        $this->assertEquals('select `users`.*, (select count(*) from `posts` where `users`.`id` = `posts`.`user_id` and `name` like ?) as `posts_count` from `users`', $query->toSql());

        // Test PostgreSQL cross database subquery
        $query = UserPgsql::withCount(['ordersWithoutPrefix' => function ($query) {
            $query->where('name', 'like', '%a%');
        },
        ]);

        $sql = $query->toSql();

        $this->assertMatchesRegularExpression('/from "pgsql3"\.(?:"pgsql3"\.)?"orders"/', $sql);
        $this->assertStringContainsString('count(*)', $sql);
        $this->assertStringContainsString('"name"::text like ?', $sql);

        // Test PostgreSQL same database subquery
        $query = UserPgsql::withCount(['posts' => function ($query) {
            $query->where('name', 'like', '%a%');
        },
        ]);
        $this->assertEquals('select "users".*, (select count(*) from "posts" where "users"."id" = "posts"."user_id" and "name"::text like ?) as "posts_count" from "users"', $query->toSql());

        // Test SQL Server cross database subquery
        $query = UserSqlsrv::withCount(['ordersWithoutPrefix' => function ($query) {
            $query->where('name', 'like', '%a%');
        },
        ]);

        $sql = $query->toSql();

        $this->assertMatchesRegularExpression(
            '/from \[sqlsrv3\](?:\.\[sqlsrv3\])?\.\[orders\]/',
            $sql
        );

        $this->assertStringContainsString('[users].[id] = [orders].[user_id]', $sql);
        $this->assertStringContainsString('count(*)', $sql);
        $this->assertStringContainsString('[name] like ?', $sql);

        // Test SQL Server same database subquery
        $query = UserSqlsrv::withCount(['posts' => function ($query) {
            $query->where('name', 'like', '%a%');
        },
        ]);
        $this->assertEquals('select [users].*, (select count(*) from [posts] where [users].[id] = [posts].[user_id] and [name] like ?) as [posts_count] from [users]', $query->toSql());

        // Test SQL Server cross database subquery
        $query = UserSqlite::withCount(['ordersWithoutPrefix' => function ($query) {
            $query->where('name', 'like', '%a%');
        },
        ]);

        $sql = $query->toSql();

        // 至少保證 orders 出現在 subquery 中
        $this->assertStringContainsString('"orders"', $sql);

        // 確保 count(*) 是存在的
        $this->assertStringContainsString('count(*)', $sql);

        // 確保有 user_id join
        $this->assertStringContainsString('"users"."id" = "orders"."user_id"', $sql);

        // 確保 where 條件還在
        $this->assertStringContainsString('"name" like ?', $sql);

        // Test SQL Server same database subquery
        $query = UserSqlite::withCount(['posts' => function ($query) {
            $query->where('name', 'like', '%a%');
        },
        ]);
        $this->assertEquals('select "users".*, (select count(*) from "posts" where "users"."id" = "posts"."user_id" and "name" like ?) as "posts_count" from "users"', $query->toSql());
    }
}

class UserMysql extends Model
{
    protected $connection = 'mysql1';
    protected $table = 'users';
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany('Hoyvoy\Tests\Integration\OrderMysql', 'user_id');
    }

    public function ordersWithoutPrefix()
    {
        return $this->hasMany('Hoyvoy\Tests\Integration\OrderWithoutPrefixMysql', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany('Hoyvoy\Tests\Integration\PostMysql', 'user_id');
    }
}

class PostMysql extends Model
{
    protected $connection = 'mysql1';
    protected $table = 'posts';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Hoyvoy\Tests\Integration\UserMysql', 'user_id');
    }
}

class OrderWithoutPrefixMysql extends Model
{
    protected $connection = 'mysql3';
    protected $table = 'orders';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Hoyvoy\Tests\Integration\UserMysql', 'user_id');
    }
}

class OrderMysql extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'orders';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Hoyvoy\Tests\Integration\UserMysql', 'user_id');
    }
}

class UserPgsql extends Model
{
    protected $connection = 'pgsql1';
    protected $table = 'users';
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany('Hoyvoy\Tests\Integration\OrderPgsql', 'user_id');
    }

    public function ordersWithoutPrefix()
    {
        return $this->hasMany('Hoyvoy\Tests\Integration\OrderWithoutPrefixPgsql', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany('Hoyvoy\Tests\Integration\PostPgsql', 'user_id');
    }
}

class PostPgsql extends Model
{
    protected $connection = 'pgsql1';
    protected $table = 'posts';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Hoyvoy\Tests\Integration\UserPgsql', 'user_id');
    }
}

class OrderWithoutPrefixPgsql extends Model
{
    protected $connection = 'pgsql3';
    protected $table = 'orders';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Hoyvoy\Tests\Integration\UserMysql', 'user_id');
    }
}

class OrderPgsql extends Model
{
    protected $connection = 'pgsql2';
    protected $table = 'orders';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Hoyvoy\Tests\Integration\UserPgsql', 'user_id');
    }
}

class UserSqlsrv extends Model
{
    protected $connection = 'sqlsrv1';
    protected $table = 'users';
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany('Hoyvoy\Tests\Integration\OrderSqlsrv', 'user_id');
    }

    public function ordersWithoutPrefix()
    {
        return $this->hasMany('Hoyvoy\Tests\Integration\OrderWithoutPrefixSqlsrv', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany('Hoyvoy\Tests\Integration\PostSqlsrv', 'user_id');
    }
}

class PostSqlsrv extends Model
{
    protected $connection = 'sqlsrv1';
    protected $table = 'posts';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Hoyvoy\Tests\Integration\UserSqlsrv', 'user_id');
    }
}

class OrderWithoutPrefixSqlsrv extends Model
{
    protected $connection = 'sqlsrv3';
    protected $table = 'orders';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Hoyvoy\Tests\Integration\UserMysql', 'user_id');
    }
}

class OrderSqlsrv extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'orders';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Hoyvoy\Tests\Integration\UserSqlsrv', 'user_id');
    }
}

class UserSqlite extends Model
{
    protected $connection = 'sqlite1';
    protected $table = 'users';
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany('Hoyvoy\Tests\Integration\OrderSqlite', 'user_id');
    }

    public function ordersWithoutPrefix()
    {
        return $this->hasMany('Hoyvoy\Tests\Integration\OrderWithoutPrefixSqlite', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany('Hoyvoy\Tests\Integration\PostSqlite', 'user_id');
    }
}

class PostSqlite extends Model
{
    protected $connection = 'sqlite1';
    protected $table = 'posts';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Hoyvoy\Tests\Integration\UserSqlite', 'user_id');
    }
}

class OrderWithoutPrefixSqlite extends Model
{
    protected $connection = 'sqlite3';
    protected $table = 'orders';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Hoyvoy\Tests\Integration\UserMysql', 'user_id');
    }
}

class OrderSqlite extends Model
{
    protected $connection = 'sqlite2';
    protected $table = 'orders';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Hoyvoy\Tests\Integration\UserSqlite', 'user_id');
    }
}
