<?php

namespace Swader\Diffbot;

use Swader\Diffbot\Exceptions\DiffbotException;

/**
 * Class Diffbot
 *
 * Основной класс работы с API
 *
 * @package Swader\Diffbot
 */
class Diffbot
{
    /** @var string Токен доступа к API */
    private static $token = null;

    /** @var string Токен экземпляра, устанавливается для каждой новой сущности */
    private $instanceToken;

    /**
     * @param string|null $token Токен доступа к API, полученный на
    diffbot.com/dev
     * @throws DiffbotException Если не передан токен
     */
    public function __construct($token = null)
    {
        if ($token === null) {
            if (self::$token === null) {
                $msg = 'Токен не передан и не установлен глобально. ';
                $msg .= 'Используйте Diffbot::setToken, или передайте его в конструктор.';
                throw new DiffbotException($msg);
            }
        } else {
            self::validateToken($token);
            $this->instanceToken = $token;
        }
    }

    /**
     * Устанавливает токен для всех новых сущностей
     * @param $token string Токен доступа к API, полученный на
    diffbot.com/dev
     * @return void
     */
    public static function setToken($token)
    {
        self::validateToken($token);
        self::$token = $token;
    }

    private static function validateToken($token)
    {
        if (!is_string($token)) {
            throw new \InvalidArgumentException('Переданный токен не является строкой.');
        }
        if (strlen($token) < 4) {
            throw new \InvalidArgumentException('Токен "' . $token . '" слишком короткий, и не является валидным.');
        }
        return true;
    }
}
