<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailUserPassword extends Notification
{
	use Queueable;

	public $user;
	public $password;

	/**
	 * Create a new notification instance.
	 *
	 * @param  \App\User  $user
	 * @param $password
	 */
	public function __construct($user, $password)
	{
		$this->user = $user;
		$this->password = $password;
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
	 *
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail()
	{
		$findUser = User::whereUuid($this->user)->first();

		$url = route('account.login');

		return (new MailMessage)->subject('Your '.config('app.name').' account login details')
			->greeting('Hello '.$findUser->first_name.' '.$findUser->last_name.'!')
			->line('Your login email address is, '.$findUser->email)
			->line('Your temporary login password is, '.$this->password)
			->line('For safety, kindly change the temporary password once you are logged in to the application.')
			->action('Login to '.config('app.name'),
				$url)->line('Thank you for using our application!');
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
