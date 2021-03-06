<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Alert.
 *
 * (c) Brian Faust <hello@basecode.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Artisanry\Alert;

use Illuminate\Session\Store;
use Illuminate\Support\MessageBag;

class Alert
{
    /**
     * The session storage.
     *
     * @var \Illuminate\Session\Store
     */
    private $session;

    /**
     * Construct a new Alert.
     *
     * \Artisanry\Alert\Alert constructor.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Flash an alert.
     *
     * @param string|array $message
     * @param string       $level
     * @param string|null  $title
     *
     * @return \Artisanry\Alert\Alert
     */
    public function flash($message, string $level = 'info', ?string $title = null): self
    {
        if (is_array($message)) {
            $message = new MessageBag($message);
        }

        $values = $this->session->get('alert.messages', []);
        $values[] = compact('message', 'level', 'title');

        $this->session->flash('alert.messages', $values);

        return $this;
    }

    /**
     * Flash a success alert.
     *
     * @param string|array $message
     * @param string|null  $title
     *
     * @return \Artisanry\Alert\Alert
     */
    public function success($message, ?string $title = null): self
    {
        return $this->flash($message, config('laravel-alert.classes.success'), $title);
    }

    /**
     * Flash an info alert.
     *
     * @param string|array $message
     * @param string|null  $title
     *
     * @return \Artisanry\Alert\Alert
     */
    public function info($message, ?string $title = null): self
    {
        return $this->flash($message, config('laravel-alert.classes.info'), $title);
    }

    /**
     * Flash a warning alert.
     *
     * @param string|array $message
     * @param string|null  $title
     *
     * @return \Artisanry\Alert\Alert
     */
    public function warning($message, ?string $title = null): self
    {
        return $this->flash($message, config('laravel-alert.classes.warning'), $title);
    }

    /**
     * Flash an error alert.
     *
     * @param string|array $message
     * @param string|null  $title
     *
     * @return \Artisanry\Alert\Alert
     */
    public function error($message, ?string $title = null): self
    {
        return $this->flash($message, config('laravel-alert.classes.error'), $title);
    }
}
