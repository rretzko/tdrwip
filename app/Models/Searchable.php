<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Searchable extends Model
{
    use HasFactory;

    private $hashed = '';
    private $searchable;
    private $searchtype = NULL;
    private $searchtype_id = 0;

    protected $fillable = ['hash'];

    /**
     * determine if $descr is a unique setting
     * if unique, confirm that row must be updated, inserted or bypassed
     * else updateOrCreate row
     *
     * @param $user
     * @param $descr
     * @param $raw
     */
    public function add(User $user, $descr, $raw)
    {
        $this->searchtype = Searchtype::where('descr', $descr)->first();
        $this->searchtype_id = $this->searchtype->id;

        //transform $raw values into lowercase for consistency
        $lc_raw = strtolower($raw);
        $this->hashed = hash_hmac('sha256', $lc_raw, config('hashing.hashkey'));
        $this->searchable = Searchable::firstOrCreate(['hash' => $this->hashed]);

        $this->user = $user;

        //ex. 'name' is a unique searchtype but 'phone*' is NOT unique
        ($this->searchtype->unique) ? $this->handleUnique() : $this->handleUnique(); //$this->>handleMultiple();
    }

    /**
     * NOTE: This removes the pivot table (searchable_user) row
     * and does NOT remove the searchable value
     * i.e. detaches without deleting original value
     *
     * @param User $user
     * @param string $descr //ex.email_work
     */
    public function remove(User $user, $descr)
    {
        $this->searchtype = Searchtype::where('descr', $descr)->first();
        $this->searchtype_id = $this->searchtype->id;
        $this->hashed = '';//hash_hmac('sha256', $raw, config('hashing.hashkey'));
        $this->user = $user;
        $this->deleteSearchableUserRow();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withPivot('searchtype_id');
    }

/** END OF PUBLIC FUNCTIONS **************************************************/

    /**
     * Couldn't figure out how to do this with detach
     *
     */
    private function deleteSearchableUserRow()
    {
        //$this->searchable may/may not be instantiated
        $operand = ($this->searchable) ? '=' : '>';
        $searchable_id = ($this->searchable) ? $this->searchable->id : 0;

        DB::table('searchable_user')
            ->where('searchable_id', $operand, $searchable_id)
            ->where('user_id', '=', $this->user->id)
            ->where('searchtype_id', '=', $this->searchtype_id)
            ->delete();
    }

    /**
     * Do nothing if current input matches database row,
     * else updateOrCreate
     */
    private function handleMultiple()
    {
        //stub
    }

    /**
     * @todo this maybe better handled with ->toggle()
     * Do nothing if current input matches database row,
     * else updateOrCreate
     */
    private function handleUnique()
    {
        //remove the current row
        $this->deleteSearchableUserRow();

        //attach new row
        $this->searchable->users()->attach($this->user->id, ['searchtype_id' => $this->searchtype_id]);
    }
}
