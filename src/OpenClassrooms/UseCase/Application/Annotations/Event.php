<?php

namespace OpenClassrooms\UseCase\Application\Annotations;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 * @Annotation
 */
class Event
{
    const PRE_METHOD = 'pre';

    const POST_METHOD = 'post';

    const ON_EXCEPTION_METHOD = 'onException';

    const DEFAULT_METHOD = self::POST_METHOD;

    /**
     * @var string[]
     */
    private static $allowedMethods = array(
        self::PRE_METHOD,
        self::POST_METHOD,
        self::ON_EXCEPTION_METHOD
    );

    /**
     * @var string
     */
    public $name;

    /**
     * @var string[]
     */
    public $methods = array(self::DEFAULT_METHOD);

    public function __construct(array $values)
    {
        if (isset($values['name'])) {
            $this->name = $values['name'];
        }

        if (isset($values['methods'])) {
            $this->methods = is_array($values['methods']) ? $values['methods'] :
                array_map('trim', explode(',', $values['methods']));
        }

        foreach ($this->methods as $method) {
            if (!in_array($method, self::$allowedMethods)) {
                throw new \InvalidArgumentException (
                    'Method "' . $method . '" is not allowed. Allowed: pre, post and onException'
                );
            }
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getMethods()
    {
        return $this->methods;
    }
}
