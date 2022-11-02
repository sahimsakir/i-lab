<?php

namespace App\Notifications;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorAuthentication extends Notification
{
	use Queueable;

	public $user;
	public $two_factor_auth_token;

	/**
	 * TwoFactorAuthentication constructor.
	 * @param $user
	 * @param $two_factor_auth_token
	 */
	public function __construct($user, $two_factor_auth_token)
	{
		$this->user = $user;
		$this->two_factor_auth_token = $two_factor_auth_token;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail()
	{
		$findUser = User::whereUuid($this->user)->first();

		return (new MailMessage)
			->subject(config('app.name').' - Your Two Factor Authentication Token ['.Carbon::now()->format('F j, Y, g:i:s A').']')
			->greeting('Hello '.$findUser->first_name.' '.$findUser->last_name.'!')
			->line('Your Login 2FA Code: '.$this->two_factor_auth_token)
			->line('IP Address: '.request()->ip())
			->line('Date and Time: '.Carbon::now()->format('F j, Y, g:i A'))
			->line('Thank you for using our application!');
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			//
		];
	}
}
