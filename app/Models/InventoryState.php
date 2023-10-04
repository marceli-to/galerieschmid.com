<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InventoryState extends Model
{
  protected $fillable = [
    'id',
    'description_de',
    'description_en',
  ];
}

