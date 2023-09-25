<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property int $id
 * @property string $sku
 * @property string $name
 * @property string $description
 * @property float $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|CategoryMapping[] $category_mappings
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'products';

	protected $casts = [
		'price' => 'float'
	];

	protected $fillable = [
		'sku',
		'name',
		'description',
		'price'
	];

	public function category_mappings()
	{
		return $this->hasMany(CategoryMapping::class);
	}
}
