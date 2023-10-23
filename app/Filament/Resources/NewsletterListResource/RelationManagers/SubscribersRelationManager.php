<?php
namespace App\Filament\Resources\NewsletterListResource\RelationManagers;
use App\Models\NewsletterSubscriber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscribersRelationManager extends RelationManager
{
  protected static string $relationship = 'newsletterSubscribers';

  protected static ?string $modelLabel = 'Abonnent';

  protected static ?string $pluralModelLabel = 'Abonnenten';

  public function form(Form $form): Form
  {
    return $form
      ->schema([

      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->heading('Abonnenten')
      ->recordTitle(fn ($record): string => "{$record->firstname} {$record->lastname}, {$record->email}")
      ->columns([
        TextColumn::make('firstname')
        ->label('Vorname')
        ->sortable()
        ->searchable(),
        TextColumn::make('lastname')
        ->label('Name')
        ->sortable()
        ->searchable(),
        TextColumn::make('email')
        ->label('E-Mail')
        ->sortable()
        ->searchable(),
      ])
      ->filters([
      ])
      ->headerActions([
        Tables\Actions\AttachAction::make('attach')
        ->form(fn (Tables\Actions\AttachAction $action): array => [
          $action->getRecordSelect(),
        ])
        ->recordSelectSearchColumns(['firstname', 'lastname', 'email'])
      ])
      ->actions([
        Tables\Actions\DetachAction::make('detach')->label('Entfernen'),
        // Tables\Actions\EditAction::make('edit')->modalWidth('2xl')
        // ->mutateRecordDataUsing(function (array $data): array {
        //   $data['user_id'] = auth()->id();
        //   return $data;
        // }),
        //Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        // Tables\Actions\BulkActionGroup::make([
        //   Tables\Actions\DeleteBulkAction::make(),
        // ]),
      ]);
  }
}
