<?php
namespace App\Filament\Resources\NewsletterQueueResource\Pages;
use App\Filament\Resources\NewsletterQueueResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletterQueue extends CreateRecord
{
  protected static string $resource = NewsletterQueueResource::class;
}
