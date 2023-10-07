<?php
namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum Gallery: string implements HasLabel, HasColor
{
  case GAP = 'gap';
  case Eule = 'eule';

  public function getLabel(): ?string
  {
    return match ($this) {
      self::GAP => 'GAP',
      self::Eule => 'Eule',
    };
  }

  public function getColor(): ?string
  {
    return match ($this) {
      self::GAP => 'success',
      self::Eule => 'warning',
    };
  }
 
}