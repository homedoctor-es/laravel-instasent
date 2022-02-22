<?php

/**
 * Part of the Instasent Laravel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Instasent Laravel
 * @version    1.0.0
 * @author     Jose Lorente
 * @license    BSD License (3-clause)
 * @copyright  (c) 2018, Jose Lorente
 */

namespace HomedoctorEs\Laravel\Instasent\Notifications\Channel;

use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use HomedoctorEs\Laravel\Instasent\Instasent;
use HomedoctorEs\Laravel\Instasent\Notifications\Messages\InstasentMessage;

/**
 * Class InstasentSmsChannel.
 * 
 * A notification channel to send SMS notifications via Instasent.
 *
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class InstasentSmsChannel
{

    /**
     * The Instasent client instance.
     *
     * @var Instasent
     */
    protected $client;

    /**
     * Create a new Instasent channel instance.
     *
     * @param Instasent $client
     * @return void
     */
    public function __construct(Instasent $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return \Instasent\Model\ResultItem
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('instasent', $notification)) {
            $to = $notifiable->phone_number;
            if (!$to) {
                return;
            }
        }

        $message = $notification->toInstasent($notifiable);
        if (is_string($message)) {
            $message = new InstasentMessage($message);
        }

        if (config('services.instasent.dry_run', false) === true) {
            return true;
        }

        try {
            return $this->client->smsClient()->sendUnicodeSms(
                            $message->from ?? config('services.instasent.default_from', 'Laravel')
                            , $to
                            , trim($message->content)
            );
        } catch (Exception $ex) {
            Log::critical('Instasent API Exception ', ['message' => $ex->getMessage()]);

            if (config('services.instasent.throw_exception_on_error', true)) {
                throw $ex;
            }

            return false;
        }
    }

}
