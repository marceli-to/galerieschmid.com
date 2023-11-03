<?php
namespace App\Filament\Resources;
use App\Filament\Resources\TeamMemberResource\Pages;
use App\Filament\Resources\TeamMemberResource\RelationManagers;
use App\Models\TeamMember;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamMemberResource extends Resource
{
  protected static ?string $model = TeamMember::class;

  protected static ?string $navigationIcon = 'heroicon-o-user';

  protected static ?string $navigationGroup = 'Seiteninhalt';

  protected static ?string $navigationLabel = 'Team';

  protected static ?string $modelLabel = 'Teammitglied';

  protected static ?string $pluralModelLabel = 'Team';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make()
        ->schema([
          Section::make('Daten')
          ->schema([
            TextInput::make('firstname')
            ->label('Vorname')
            ->required(),
            TextInput::make('lastname')
            ->label('Name')
            ->required(),
            TextInput::make('email')
            ->label('E-Mail')
            ->email()
          ])->columnSpan(8),
        ])->columns(12),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
    ->striped()
    ->reorderable('position')
    ->defaultSort('position', 'ASC')
    ->columns([
      TextColumn::make('firstname')
      ->label('Vorname')
      ->searchable()
      ->sortable(),
      TextColumn::make('lastname')
      ->label('Name')
      ->searchable()
      ->sortable(),
      TextColumn::make('email')
      ->label('E-Mail')
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
      'index' => Pages\ListTeamMembers::route('/'),
      'create' => Pages\CreateTeamMember::route('/create'),
      'edit' => Pages\EditTeamMember::route('/{record}/edit'),
    ];
  }    
}
