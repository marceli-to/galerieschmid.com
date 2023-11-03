<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'firstname',
    'lastname',
    'email',
    'position',
    'user_id',
  ];
}
