<?php
namespace App\Filament\Resources\TeamMemberResource\Pages;
use App\Filament\Resources\TeamMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTeamMember extends CreateRecord
{
  protected static string $resource = TeamMemberResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
