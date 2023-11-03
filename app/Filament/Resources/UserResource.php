<?php
namespace App\Filament\Resources;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
  protected static ?string $model = User::class;

  protected static ?string $navigationIcon = 'heroicon-o-user-group';

  protected static ?string $navigationLabel = 'Benutzer';

  protected static ?string $modelLabel = 'Benutzer';

  protected static ?string $pluralModelLabel = 'Benutzer';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make()
        ->schema([
          Section::make('Benutzerdaten')
          ->schema([
            TextInput::make('name')
            ->label('Name')
            ->required(),
            TextInput::make('email')
            ->label('E-Mail')
            ->email()
            ->required(),
            TextInput::make('password')
            ->label('Passwort')
            ->password()
            ->disableAutocomplete()
            ->dehydrateStateUsing(fn (string $state): string => \Hash::make($state))
            ->dehydrated(fn (?string $state): bool => filled($state))
            ->required(fn (string $operation): bool => $operation === 'create'),
          ])->columnSpan(8),
        ])->columns(12),
      ]);
  }

    public static function table(Table $table): Table
    {
      return $table
        ->striped()
        ->columns([
          TextColumn::make('name')
          ->label('Name')
          ->searchable()
          ->sortable(),
          TextColumn::make('email')
          ->label('E-Mail/Benutzername')
          ->searchable()
          ->sortable(),
        ])
        ->filters([
        ])
        ->actions([
          Tables\Actions\EditAction::make(),
          Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
          Tables\Actions\BulkActionGroup::make([
            Tables\Actions\DeleteBulkAction::make(),
          ]),
        ]);
    }
    
    public static function getRelations(): array
    {
      return [
      ];
    }
    
    public static function getPages(): array
    {
      return [
        'index' => Pages\ListUsers::route('/'),
        'create' => Pages\CreateUser::route('/create'),
        'edit' => Pages\EditUser::route('/{record}/edit'),
      ];
    }    
}
