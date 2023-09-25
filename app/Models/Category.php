<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|CategoryMapping[] $category_mappings
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'categories';

	protected $fillable = [
		'name'
	];

	public function category_mappings()
	{
		return $this->hasMany(CategoryMapping::class);
	}
}
