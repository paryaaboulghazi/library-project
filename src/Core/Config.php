<?php

namespace Src\Core;

use Exception;

class Config
{
    public static array $config = [];

    /**
     * Load the configuration from the config file.
     *
     * @throws Exception If the configuration file is not found.
     */
    public static function loadConfig(): void
    {
        $configPath = __DIR__ . '/../config.php';

        if (!file_exists($configPath)) {
            throw new Exception("Config file not found: $configPath");
        }

        self::$config = include $configPath;
    }

    /**
     * Get a specific configuration value.

     *
     * @param string $key The dot-separated key to access the nested configuration.
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        $keys = explode('.', $key);
        $config = self::$config;

        foreach ($keys as $keyPart) {
            if (!isset($config[$keyPart])) {
                return null;
            }
            $config = $config[$keyPart];
        }

        return $config;
    }

    /**
     * Get all the configuration settings.
     *
     * @return array
     */
    public static function all(): array
    {
        return self::$config;
    }
}
