<?php
declare(strict_types=1);

namespace App\Utility;

use Exception;

class CacheRequest
{
    /**
     * @var array
     */
    protected static array $data = [];

    /**
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public static function read(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return self::$data;
        }

        return self::$data[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function write(string $key, mixed $value): void
    {
        self::$data[$key] = $value;
    }

    /**
     * @param string $key
     * @return void
     */
    public static function delete(string $key): void
    {
        unset(self::$data[$key]);
    }

    /**
     * @return void
     */
    public static function clear(): void
    {
        self::$data = [];
    }

    /**
     * @return array
     */
    public static function keys(): array
    {
        return array_keys(self::$data);
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return isset(self::$data[$key]);
    }

    /**
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public static function readOrFail(string $key): mixed
    {
        if (!self::has($key)) {
            throw new Exception("Key {$key} not found");
        }

        return self::read($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     * @throws \Exception
     */
    public static function writeOrFail(string $key, mixed $value): void
    {
        if (self::has($key)) {
            throw new Exception("Key {$key} already exists");
        }

        self::write($key, $value);
    }

    /**
     * @param string $key
     * @return void
     * @throws \Exception
     */
    public static function deleteOrFail(string $key): void
    {
        if (!self::has($key)) {
            throw new Exception("Key {$key} not found");
        }

        self::delete($key);
    }

    /**
     * @param string $key
     * @param callable $callback
     * @return mixed
     */
    public static function remember(string $key, callable $callback): mixed
    {
        if (self::has($key)) {
            return self::read($key);
        }

        $value = $callback();

        self::write($key, $value);

        return $value;
    }
}
