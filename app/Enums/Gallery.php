<?php
namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
 
enum Gallery: string implements HasLabel
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
 
}