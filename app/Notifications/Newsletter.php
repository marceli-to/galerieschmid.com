<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\NewsletterQueue;
use App\Models\Newsletter as NewsletterModel;
use App\Models\NewsletterSubscriber;

class Newsletter extends Notification
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(NewsletterModel $newsletter, NewsletterSubscriber $subscriber)
  {
    $this->data = [
      'newsletter' => NewsletterModel::with('articles.media')->find($newsletter->id),
      'subscriber' => $subscriber,
    ];
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
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    return (new MailMessage)
      ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
      ->subject('Galerie Schmid – ' . $this->data['newsletter']->title)
      ->markdown('email.newsletter', ['data' => $this->data]);
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
