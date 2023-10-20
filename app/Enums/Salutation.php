<?php
namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum Salutation: string implements HasLabel, HasColor
{
  case HERR = 'Herr';
  case FRAU = 'Frau';
  case UNBEKANNT = 'Unbekannt';

  public function getLabel(): ?string
  {
    return match ($this) {
      self::HERR => 'Herr',
      self::FRAU => 'Frau',
      self::UNBEKANNT => 'Unbekannt',
    };
  }

  public function getColor(): ?string
  {
    return match ($this) {
      self::HERR => 'success',
      self::FRAU => 'success',
      self::UNBEKANNT => 'warning',
    };
  }
 
}