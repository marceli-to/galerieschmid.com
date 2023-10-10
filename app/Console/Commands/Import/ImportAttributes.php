<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\Attribute;
use App\Models\AttributeGroup;

class ImportAttributes extends Command
{
  protected $signature = 'import:attributes';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_objekte_attributes.json';

  protected $model = Attribute::class;

  protected $groupModel = AttributeGroup::class;

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $this->info('Import of file '. $this->file .' started...');
    
    // Read contents of $file located at /storage/app/import
    $json = \File::get(storage_path('app/import/' . $this->file));

    // Parse json
    $data = json_decode($json);

    // Find item with "type = table"
    $table = collect($data)->where('type', 'table')->first();
    $groups = collect($table->data)->where('ownerEl', 0);

    foreach($groups as $group)
    {
      $this->groupModel::create([
        'id' => $group->Id,
        'description_de' => $group->name,
        'description_en' => $group->name . ' (en)',
        'user_id' => 1,
      ]);
    }

    $attributes = collect($table->data)->where('ownerEl', '>', 0);
    foreach($attributes as $attribute)
    {
      $this->model::create([
        'id' => $attribute->Id,
        'description_de' => $attribute->name,
        'description_en' => $attribute->name . ' (en)',
        'attribute_group_id' => $attribute->ownerEl ?? NULL,
        'user_id' => 1,
      ]);
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');

  }
}
