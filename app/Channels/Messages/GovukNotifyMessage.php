<?php

namespace App\Channels\Messages;

use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Notifications\Messages\SimpleMessage;

class GovukNotifyMessage extends SimpleMessage
{
    /**
     * The "to" information for the message.
     *
     * @var string
     */
    public $to;

    /**
     * The "template" to be used for the message.
     *
     * @var string
     */
    public $templateId;

    /**
     * The parameters for the message.
     *
     * @var array
     */
    public $parameters = [];

    /**
     * Set the to email address for the mail message.
     *
     * @param  string  $emailAddress
     * @return $this
     */
    public function to($emailAddress)
    {
        $this->to = $emailAddress;

        return $this;
    }

    /**
     * Set the default template.
     *
     * @param  string  $template
     * @return $this
     */
    public function templateId($templateId)
    {
        $this->templateId = $templateId;

        return $this;
    }

    /**
     * Set the parameters for for the mail message.
     *
     * @param  array  $params
     * @return $this
     */
    public function parameters($params = [])
    {
        $this->parameters= $params;

        return $this;
    }
}
