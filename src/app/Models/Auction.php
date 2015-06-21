<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model {

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'auctions';

	protected $dates = ['deleted_at'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'end_date', 'description', 'owner_id', 'category_id', 'picture'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	// protected $hidden = [];

	public function owner() {
		return $this->belongsTo('App\User', 'owner_id');
	}

	public function winner() {
		return $this->belongsTo('App\User', 'winner_id');
	}

	public function category() {
		return $this->belongsTo('App\Models\Category');
	}

	public function offers() {
		return $this->hasMany('App\Models\Offer');
	}

	public function comments() {
		return $this->hasMany('App\Models\Comment');
	}

	public function pictureUrl() {
		return asset('images/'.$this->picture);
	}

	public function scopeNameIncludes($query, $string) {
		return $query->where('name', 'LIKE', '%'.$string.'%');
	}

	public function scopeCurrents ($query) {
		return $query->where('end_date', '>', Date('Y/m/d H:i:s'));
	}

	public function scopeIsOfCategory($query, $categoryId) {
		return $query->where('category_id', '=', $categoryId);
	}

	public function remainingDays(){
		return (new \DateTime($this->end_date))->diff(new \DateTime("now"))->d;
    }

	public static function rules () {
		return [
			'name' => 'required|string|max:255|min:3',
			'description' => 'required',
			'owner_id' => 'required|exists:users,id',
			'category_id' => 'required|exists:categories,id',
			'end_date' => 'required',
			'picture' => 'required|string|min:4'
		];
	}

	public function isDeleteable() {

		if (count($this->offers) > 0) { //si tiene ofertas

			if ($this->end_date < Date('Y/m/d H:i:s')){ //si tiene ofertas y pero ya cerró

				return true;
			}

			return false;

		} else { //si no tiene ofertas

			return true;

		}

	}


}
